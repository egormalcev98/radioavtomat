<?php

namespace App\Services\TodayJobs;

use App\Events\TodayJobs\TodayJobsNotifications;
use App\Models\IncomingDocuments\IncomingDocumentUser;
use App\Models\Notes\Note;
use App\Models\Tasks\Task;
use App\Models\TodayJobs\TodayJob;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use phpDocumentor\Reflection\Types\Collection;

class TodayJobsService
{
    public $templatePath = 'crm.today_jobs.';
    public $translation = 'today_jobs.';
    private $userId = null;

    public function getTodayJobs()
    {
        return TodayJob::where('user_id', auth()->id())->get();
    }

    public function rewriteTodayJobs($userId = null)
    {
        if(!$this->userId) {
            $this->userId = auth()->id();
        }

        $start = Carbon::now()->startOfDay()->toDateTimeString();
        $end = Carbon::now()->endOfDay()->toDateTimeString();
        $subPeriod =  Carbon::now()->subDay()->toDateTimeString();

        TodayJob::where('user_id', $this->userId)->delete();

        // задачи
        $todayTasks = $this->scopeOfTask()->where('start', '>', $start)->where('end', '<', $end)->get();
        $this->saveTaskJobs($todayTasks);
        $todayTasks = $this->scopeOfTask()->where('end', '<', $subPeriod)->get();
        $this->saveTaskJobs($todayTasks, true);

        // записки
        $todayNotes = $this->scopeOfNote()->whereBetween('created_at', [$start, $end])->get();
        $this->saveNoteJobs($todayNotes);
        $todayNotes = $this->scopeOfNote()->where('created_at', '<', $subPeriod)->get();
        $this->saveNoteJobs($todayNotes, true);

        // всходящие документы
        $todayDocs = $this->scopeOfDocs()->whereBetween('sign_up', [$start, $end])->get();
        $this->saveDocJobs($todayDocs);
        $todayDocs = $this->scopeOfDocs()->where('sign_up', '<', $subPeriod)->get();
        $this->saveDocJobs($todayDocs, true);

        return true;
    }

    public function saveTaskJobs($tasks, $red = null)
    {
        foreach ($tasks as $task) {
            $todayJob = $this->getNewTodayJob($task, $red);
            $eventType = $task->eventType->name ?? '';
            $text = $task->taskType->name . ' #' . $task->id . ' ' . $eventType . '. ' . $task->text . '. ' . Carbon::parse($task->start)->format('d.m.Y H:i') . ' - ' . Carbon::parse($task->end)->format('d.m.Y H:i');
            $onClick = "TaskGlobal.getInfo('" . route('tasks.info', $task->id) . "');";
            $todayJob->href = '<a href="javascript:void(0);" onclick="' . $onClick . '">' . $text . '</a>';
            if ($red) {
                $allowedRoutes = [];
                $allowedRoutes[] = parse_url(route('tasks.info', $task->id), PHP_URL_PATH);
                $allowedRoutes[] = parse_url(route('tasks.edit', $task->id), PHP_URL_PATH);
                $allowedRoutes[] = parse_url(route('tasks.destroy', $task->id), PHP_URL_PATH);
                $todayJob->allowed_routes = serialize($allowedRoutes);
            }

            $todayJob->save();
        }

        return true;
    }

    public function saveNoteJobs($notes, $red = null)
    {
        foreach ($notes as $note) {
            $todayJob = $this->getNewTodayJob($note, $red);
            $text = "Служебная записка #" . $note->number . ' ' . $note->title;
            $todayJob->href = '<a href="' . route('notes.show', $note->id) . '">' . $text . '</a>';
            if ($red) {
                $allowedRoutes = [];
                $allowedRoutes[] = parse_url(route('notes.show', $note->id), PHP_URL_PATH);
                $allowedRoutes[] = parse_url(route('notes.edit', $note->id), PHP_URL_PATH);
                $todayJob->allowed_routes = serialize($allowedRoutes);
            }

            $todayJob->save();
        }

        return true;
    }

    public function saveDocJobs($docs, $red = null)
    {
        foreach ($docs as $doc) {
            $todayJob = $this->getNewTodayJob($doc, $red);
            $text = "Вх. документ № " . $doc->incomingDocument->number . ' ' . $doc->incomingDocument->title;
            $todayJob->href = '<a href="' . route('incoming_documents.show', $doc->incoming_document_id) . '">' . $text . '</a>';
            if ($red) {
                $allowedRoutes = [];
                $allowedRoutes[] = parse_url(route('incoming_documents.show', $doc->incoming_document_id), PHP_URL_PATH);
                $allowedRoutes[] = parse_url(route('incoming_documents.edit', $doc->incoming_document_id), PHP_URL_PATH);
                $todayJob->allowed_routes = serialize($allowedRoutes);
            }

            $todayJob->save();
        }

        return true;
    }

    public function scopeOfTask()
    {
        return Task::whereIn('task_status_id', [1, 3])
            ->with(['taskType', 'eventType', 'users'])
            ->whereHas('users', function ($user) {
                return $user->where('id', $this->userId);
            });
    }

    public function scopeOfNote()
    {
        return Note::where('user_id',  $this->userId)
            ->where('status_note_id', 1);
    }

    public function scopeOfDocs()
    {
        return  IncomingDocumentUser::where('user_id', $this->userId)
            ->has('incomingDocument')
            ->with('incomingDocument')
            ->whereNull('signed_at')
            ->whereNull('reject_at')
            ->where('type', 2);
    }

    public function getNewTodayJob($item, $red)
    {
        $todayJob = new TodayJob();
        $todayJob->user_id = $this->userId;
        $todayJob->red = $red;
        $todayJob->created_at = $item->created_at;

        return $todayJob;
    }

    public function notify()
    {
        $userIds = User::withoutAdmin()->select('id')->get()->pluck('id')->toArray();

        foreach ($userIds as $id){
            $this->userId = $id;
            $this->rewriteTodayJobs();
            $item = collect();
            $item->created_at = Carbon::now();
            $todayJob = $this->getNewTodayJob($item, true);
            $todayJob->missed = true;
            $todayJob->save();
            event(new TodayJobsNotifications($id));
            sleep(5);
        }

        return true;
    }

}
