<?php

namespace App\Services\Tasks;

use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\EventType;
use App\Models\References\StructuralUnit;
use App\Models\References\TaskStatus;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskType;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskService
{
    public $templatePath = 'crm.tasks.';
    public $translation = 'tasks.';
    public $permissionKey = 'task';

    public $russianMonths = [
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь',
    ];

    public $russianMonthsTranslete = [
        'January' => 'Января',
        'February' => 'Февраля',
        'March' => 'Мара',
        'April' => 'Апреля',
        'May' => 'Мая',
        'June' => 'Июня',
        'July' => 'Июля',
        'August' => 'Августа',
        'September' => 'Сентября',
        'October' => 'Октября',
        'November' => 'Ноября',
        'December' => 'Декабря',
    ];

    public function model()
    {
        return new Task();
    }

    public function outputData()
    {
        // dd($this->getWeekPeriod('01.04.2020', '30.08.2020'));
        $with = [
            'translation' => 'tasks',
            'users' => $this->getResponsibleUsers(),
            'years' => $this->getLastYears(6),
            'months' => $this->getLastMonths(6),
            'allMonths' => $this->getAllMonths(),
            'taskStatuses' => TaskStatus::all(),
            'getTasksUrl' => route('tasks.get'),
            'referenStatuses' => [],
        ];

        if (\auth()->user()->can('create_task')) {

            $with['routeCreateTask'] = route('tasks.create', ['type' => 'task']);

            if (\auth()->user()->can('orders_access')) {
                $with['routeCreateOrder'] = route('tasks.create', ['type' => 'order']);
            }
        }

        return $with;
    }

    public function getTasks($request)
    {
        $tasksFilteredStart = Task::whereBetween('start', [$request->start, $request->end])->get()->pluck('id')->toArray();
        $tasksFilteredEnd = Task::whereBetween('end', [$request->start, $request->end])->get()->pluck('id')->toArray();
        $tasksIds = array_merge($tasksFilteredStart, $tasksFilteredEnd);
        $tasksIds = array_unique($tasksIds);
        $tasks = Task::whereIn('id', $tasksIds);

        if ($request->has('users') and $request->users) {
            $usersIds = explode(',', $request->users);
            if (!$this->checkAuthIsManagementTeam()) { // если НЕ руководящий состав
                $usersIds = $this->checkAccessToResponsibleUsers($usersIds);
            }
            $tasks->whereHas('users', function ($query) use ($usersIds) {
                return $query->whereIn('id', $usersIds);
            });
        } else {
            $tasks->whereHas('users', function ($query) {
                return $query->where('id', \auth()->id());
            });
        }

        if ($request->has('taskStatus') and $request->taskStatus) {
            $tasks->where('task_status_id', $request->taskStatus);
        }

        $tasks = $tasks
            ->with(['taskStatus', 'taskType', 'eventType', 'incomingDocument', 'users'])
            ->get();

        return $this->parseWeeklyEventFromCalendar($tasks, $usersIds ?? []);
    }

    public function parseWeeklyEventFromCalendar($tasks, $usersIds = [])
    {
        $result = [];

        foreach ($tasks as $key => $item) {
            $status = $item->taskStatus->name ?? null;
            $user = $this->getFirstUsersOnTask($item, $usersIds)->surnameWithInitials ?? null;
            $usersCount = $item->users->count();
            $usersCount--;
            if ($usersCount > 0) {
                $user .= ' +' . $usersCount;
            }
            $doc = $item->incomingDocument->number ?? null;
            $color = $item->taskType->color ?? 'Red';
            if ($item->task_type_id == 1 and $item->task_status_id == 2) {
                $color = 'DarkGreen'; // если это задача и она выполнена
            }
            $eventTypename = $item->eventType->name ?? '';

            $result[] = [
                'title' => $item->taskType->name . ': ' . $eventTypename,
                'id' => $item->id,
                'start' => $item->start,
                'end' => $item->end,
                'color' => $color,
                'textColor' => $item->taskType->text_color,
                'rendering' => view($this->templatePath . 'description')
                    ->with([
                        'status' => $status,
                        'user' => $user,
                        'doc' => $doc,
                    ])->render(),
                'extendedProps' => [
                    'taskInfoUrl' => route('tasks.info', $item->id),
                ]
            ];
        }
        return $result;
    }

    // если руководящий состав
    public function checkAuthIsManagementTeam()
    {
        return \auth()->user()->structural_unit_id == 1;
    }

    public function getResponsibleUsers()
    {
        if ($this->checkAuthIsManagementTeam()) {
            return User::withoutAdmin()->get();
        }

        if (\auth()->user()->can('head_of_department')) { // если начальник отдела
            return User::withoutAdmin()->where('structural_unit_id', \auth()->user()->structural_unit_id)->get();
        }

        return User::where('id', \auth()->id())->get();
    }

    // отсееваем тех к кому нет доспупа, на тот случай если попытались обмануть систему с фронта
    public function checkAccessToResponsibleUsers($neededUserIds)
    {
        $users = $this->getResponsibleUsers()->pluck('id')->toArray();

        return array_intersect($neededUserIds, $users);
    }

    public function getLastYears($count)
    {
        $result = [];
        for ($i = $count - 1; $i >= 0; $i--) {
            $result[] = Carbon::now()->subYears($i)->format('Y');
        }

        return $result;
    }

    public function getLastMonths($count)
    {
        $result = [];
        for ($i = $count - 1; $i >= 0; $i--) {
            $now = Carbon::now()->subMonths($i);
            $result[] = [
                'number' => $now->format('m'),
                'month' => $this->russianMonths[$now->format('m')],
                'year' => $now->format('Y')
            ];
        }

        return $result;
    }

    public function getAllMonths()
    {
        $result = [];
        for ($i = 12; $i >= 0; $i--) {
            $now = Carbon::now()->subMonths($i);
            $result[] = [
                'number' => $now->format('m'),
                'month' => $this->russianMonths[$now->format('m')],
                'year' => $now->format('Y')
            ];
        }
        for ($i = 1; $i < 13; $i++) {
            $now = Carbon::now()->addMonths($i);
            $result[] = [
                'number' => $now->format('m'),
                'month' => $this->russianMonths[$now->format('m')],
                'year' => $now->format('Y')
            ];
        }

        return $result;
    }

    public function taskInfo($task)
    {
        if ($task->task_type_id == 1) {
            $event = $task->eventType->name ?? 'Неопределен';
            $status = $task->taskStatus->name ?? 'Неопределен';
        }

        $user = $this->getFirstUsersOnTask($task)->fullName ?? null;
        $usersCount = $task->users->count();
        $usersCount--;

        $with = [
            'title' => $task->taskType->name,
            'event' => $event ?? null,
            'status' => $status ?? null,
            'text' => $task->text,
            'time' => Carbon::parse($task->start)->format('d.m.Y H:i') . ' - ' . Carbon::parse($task->end)->format('d.m.Y H:i'),
            'incomingDocument' => $task->incomingDocument->number ?? null,
            'file' => [
                'name' => $task->file_name,
                'path' => $task->file_path,
            ],
            'user' => $user,
            'usersCount' => $usersCount,
            'editUrl' => null,
            'deleteUrl' => null,
            'IAmCreator' => auth()->id() == $task->creator_id,
        ];

        if (\auth()->user()->can('update_task')) {
            $with['editUrl'] = route('tasks.edit', $task->id);
        }

        if (\auth()->user()->can('delete_task')) {
            $with['deleteUrl'] = route('tasks.destroy', $task->id);
        }

        return response()->json(view($this->templatePath . 'show_modal')->with($with)->render());
    }


    public function createTask($type)
    {
        $with = $this->outputDataCreateOrUpdate($type);

        return response()->json(view($this->templatePath . 'create_or_update_modal')->with($with)->render());
    }

    public function editTask($task)
    {
        $with = $this->outputDataCreateOrUpdate($task->taskType->system_name);
        $with['task'] = $task;
        $with['taskStatuses'] = TaskStatus::select('id', 'name')->OrderedGet();
        $with['action'] = route('tasks.update_' . $task->taskType->system_name, $task->id);

        return response()->json(view($this->templatePath . 'create_or_update_modal')->with($with)->render());
    }

    public function outputDataCreateOrUpdate($type)
    {
        $with = [
            'users' => $this->getResponsibleUsers(),
            'type' => $type,
            'action' => route('tasks.store_' . $type)
        ];

        if ($type == 'task') {
            $with['eventTypes'] = EventType::select('id', 'name')->OrderedGet();
            $with ['incomingDocs'] = IncomingDocument::select('id', 'number')->OrderedGet();
            $with ['title'] = TaskType::find(1)->name;
        }
        if ($type == 'order') {
            if (\auth()->user()->can('orders_access')) {
                $with['structuralUnits'] = StructuralUnit::select('id', 'name')->OrderedGet();
            }
            $with['title'] = TaskType::find(2)->name;
        }

        return $with;
    }

    public function storeOrUpdateTask($request, $typeId, $task = null)
    {
        if (!$task) {
            $task = new Task;
        }
        $task->start = Carbon::parse($request->date_start);
        $task->end = Carbon::parse($request->date_end);
        $task->text = $request->text;
        $task->event_type_id = $request->event_type_id ?? null;
        $task->task_status_id = 1;
        $task->remember_time = $request->remember_time;
        $task->creator_id = \auth()->id();
        $task->incoming_document_id = $request->incoming_document_id ?? null;
        if ($typeId) {
            $task->task_type_id = $typeId;
        }

        if ($request->has('new_scan_file')) {
            $newFile = $request->new_scan_file;
            $originalName = $newFile->getClientOriginalName();
            $fileSave = $newFile->storeAs('task_files', $originalName, 'public');
            $task->file_name = $originalName;
            $task->file_path = $fileSave;
        }

        if ($request->has('select_all')) {
            $users = $this->getResponsibleUsers()->pluck('id')->toArray();
            $task->select_all = 1;
            $task->structural_unit_id = null;
        }

        if ($request->has('structural_unit_id') and $request->structural_unit_id) {
            $tructuralUnit = StructuralUnit::find($request->structural_unit_id);
            if ($tructuralUnit) {
                $users = $tructuralUnit->users()->get()->pluck('id')->toArray();
            }
            $task->structural_unit_id = $request->structural_unit_id;
            $task->select_all = null;
        }


        if ($request->has('task_status_id')) {
            $task->task_status_id = $request->task_status_id;
        }

        if ($request->has('user_ids') and is_array($request->user_ids)) {
            $users = $request->user_ids;
            $task->structural_unit_id = null;
            $task->select_all = null;
        }


        if (isset($users)) {
            if (!$this->checkAuthIsManagementTeam()) {
                $users = $this->checkAccessToResponsibleUsers($users);
            }
            $task->save();
            $task->users()->sync($users);
        }

        //Уведомления, перетащил сюда не зря
        $mainService = app(\App\Services\Main\MainService::class);

        $idUsers = $task->users->pluck('id')->toArray();

        if (!empty($idUsers)) {

            $params = [
                'user_id' => $idUsers
            ];

            if ($task->wasRecentlyCreated) {
                $params['send_email'] = [
                    'text' => 'Новая задача ' . implode([$task->start, $task->end], ' - ') . ': ' . $task->text,
                    'url' => route('tasks.index')
                ];
            }

            $mainService->userNotify($params);
        }

// 		//Уведомления, перетащил сюда не зря
// 		$mainService = app(\App\Services\Main\MainService::class);

// 		$idUsers = $task->users->pluck('id')->toArray();

// 		if(!empty($idUsers)) {

// 			$params = [
// 				'user_id' => $idUsers
// 			];

// 			if($task->wasRecentlyCreated) {
// 				$params['send_email'] = [
// 					'text' => 'Новая задача ' . implode([ $task->start, $task->end ], ' - ') . ': '  . $task->text,
// 					'url' => route('tasks.index')
// 				];
// 			}

// 			$mainService->userNotify($params);
// 		}


        return true;
    }

    public function destroyElement($task)
    {
        $taskUsers = $task->users();
        if ($task->delete()) {
            $taskUsers->sync([]);
            return true;
        } else {
            return false;
        }
    }

    public function getFirstUsersOnTask($task, $usersIds = [])
    {
        return $task->users()->where('id', \auth()->id())->first() ?? $task->users()->whereIn('id', $usersIds)->first() ?? $task->users->first();
    }


    public function getWeeks($request)
    {
        $dateStart = Carbon::parse($request->date)->subMonths(4)->format('d.m.Y');
        $dateEnd = Carbon::parse($request->date)->addMonths(4)->format('d.m.Y');
        $weeks = $this->getWeekPeriod($dateStart, $dateEnd);

        return response()->json(view($this->templatePath . 'weeks')->with(['weeks' => $weeks])->render());
    }

    /**
     * @param string $from начало периода
     * @param string $to конец периода
     *
     * @return array
     */
    public function getWeekPeriod($from, $to)
    {
        $weeks = [];
        $from = strtotime($from);
        $to = strtotime($to);

        while ($from < $to) {
            // номер дня недели начала периода
            $fromDay = date("N", $from);
            // если не ВС
            if ($fromDay < 7) {
                // кол-во дней до ВС
                $daysToSun = 7 - $fromDay;
                // конец недельного периода
                $end = strtotime("+ $daysToSun day", $from);

                // если попадаем на след. месяц, то делаем новые вычисления
                if (date("n", $from) != date("n", $end)) {
                    $end = strtotime("last day of this month", $from);
                }

                $weeks[] = ['start' => date('d.m.Y', $from), 'end' => date('d.m.Y', $end), 'formated' => date('Y-m-d', $from)];
                $from = $end;
            } else {
                $weeks[] = ['start' => date('d.m.Y', $from), 'end' => date('d.m.Y', $from), 'formated' => date('Y-m-d', $from)];
            }
            $from = strtotime("+1 day", $from);
        }

        return $weeks;
    }

    public function changeTaskStatusesOnCron()
    {
        $now = Carbon::now()->toDateTimeString();
        $tasks = Task::where('task_status_id', 1)->where('end', '<', $now)->get();
        foreach ($tasks as $task) {
            $task->task_status_id = 3;
            $task->save();
        }

        return true;
    }

    public function toRemind()
    {
        $tasks = Task::whereIn('task_status_id', [1, 3])
            ->with('users')
            ->whereRaw('start <= ADDDATE(NOW(), INTERVAL remember_time MINUTE)')
            ->whereHas('users', function ($user) {
                return $user->whereNull('completed');
            })
            ->get();

        foreach ($tasks as $task) {
            $eventType = $task->eventType->name ?? 'Неопределен';
            $date = Carbon::parse($task->start)->format('j F Y, H:i');
            $month =  Carbon::parse($task->start)->format('F');
            $date = str_replace($month, $this->russianMonthsTranslete[$month], $date);
            $onClick =  "TaskGlobal.getInfo('" . route('tasks.info', $task->id) . "');";
            $text = $task->text;
            $text =  view($this->templatePath . 'task_info_href') ->with(['onClick' => $onClick, 'text' => $text,])->render();
            $users = $task->users()->whereNull('completed')->get();
            foreach ($users as $user) {
                $newMessage = $user->sentChatMessages()
                    ->create([
                        'text' => 'Напоминание: ' . $eventType . '. ' . $text . '. ' . $date,
                        'to_user_id' => $user->id, //ID получателя
                    ]);

                $chatService = app(\App\Services\Chat\ChatService::class);

                $chatService->eventNewMessage($newMessage, $user);

                $this->doCompleted($task, $user->id);
            }
        }

        return true;
    }

    private function doCompleted($task, $userId)
    {
        $task->users()->syncWithoutDetaching([$userId => ['completed' => true]]);

        return true;
    }

}
