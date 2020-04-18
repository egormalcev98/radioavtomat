<?php

namespace App\Services\Tasks;

use App\Models\Tasks\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskService
{
    public $templatePath = 'crm.tasks.';
    public $translationKeys = 'tasks.';

    public function title($title, $page)
    {
        return __($this->translationKeys .$title);
    }

    public function model()
    {
        return new Task();
    }

	    public function outputData($page = null)
    {
        $with = [
            'translation' => 'tasks',
            'title' => $this->title('indexTitle',$page),
            'routeCreate' => route('tasks.' . 'create', $page != null ? $page : ''),
			'referens'	=> [],
			'responsibles'	=> [],
            'add_element_route' => 'tasks',
            'form_method' => 'POST',
            'materials' => [],
            'referenStatuses' => [],

        ];

        return $with;
    }


	public function getTasks($request)
    { return [];
		if($request->user && !empty($request->user)) {
		    $userID = $request->user;
        } else {
            $userID = Auth::user()->id;
        }

//        if($request->end && !empty($request->end)){
//            $end =  Carbon::parse(request()->end);
//        }
//        if($request->start && $request->end)
//        {
        $tasks = Task::with('material','material.referen')->where('user_id', $userID);
        if($userID != Auth::user()->id) {
            $tasks->where('creator_id' ,Auth::user()->id);
        }
        if($request->material && !empty($request->material)) {
            $tasks->whereHas('material',function ($query) use ($request) {
                $query->where('id',  $request->material);
            });
        }
        if($request->status && !empty($request->status)) {
            $tasks->whereHas('material',function ($q) use ($request) {
                $q->where('referen_id',  $request->status);
            });
        }
        return $this->parseWeeklyEventFromCalendar($tasks->get());
    }

	    public function parseWeeklyEventFromCalendar($data)
    {
        $result = [];
        $today = Carbon::now();
        foreach ($data as $key => $item) {
            $short = iconv('UTF-8', 'windows-1251', $item['title']);
            $short = substr($short, 0, 100);
            $short = iconv('windows-1251', 'UTF-8', $short);
            $result[] = [
//                'title' => $item['eventType']['name'] . ' ' . $short ,
                'title' => 'Задача:' . ($item->material ? $item->material->referen->name : $item->title) ,
                'id' => $item->id,
                'start' => $item->start,
                'end' => $item->end,
//                'end' => Carbon::parse($item['start'])->addMinutes(30)->format('Y-m-d H:i:s'),
                'extendedProps' => [

                    'id'    => $item->id,
                    'title' => $item->title,
                    'material' => $item->material? $item->material->id : 0,
                    'userId' => $item->user_id,
                    'start' => Carbon::parse($item->start)->format('Y-m-d H:i'),
                    'end' => Carbon::parse($item->end)->format('Y-m-d H:i'),
                    'description' => $item->description,
                ],
                'description' => $item['description'],
            ];
            if($item->material) {
                if($item->material->referen->id == 1) {
                    $result[$key]['color'] = '#4B7902';
                } elseif($item->material->referen->id == 2) {
                    $result[$key]['color'] = '#F59A23';
                }elseif($item->material->referen->id == 3) {
                    $result[$key]['color'] = '#015478';
                }elseif($item->material->referen->id == 4) {
                    $result[$key]['color'] = '#420080';
                }
            }else {
                $result[$key]['color'] = '#dbec98';
            }
        }
        return $result;
    }

    // public function fullWay($page = null)
    // {
        // $data = [
            // 'name' => 'Партнеры',
            // 'route' => route($this->nameController . 'index'),
        // ];
        // $page != null ? $with = $data : $with[0] = $data;
        // return $with;
    // }

    // public function excel($partner)
    // {
        // $result = $partner->inquiries;
        // $name = 'Результаты по запросам партнера ' . $partner->name;
        // return Excel::download(new ResultExport($result), $name .'.xlsx');
    // }

	public function storeElement($request)
	{
		$data = $request->toArray();
        $dateStart = $request->start;
		$dateEnd = $request->end;
        $data['creator_id'] = Auth::user()->id;
        $data['branch_id'] = Auth::user()->branch_id;
        $data['department_id'] = Auth::user()->department_id;
        $data['status_id'] = 1;
        $data['start'] = Carbon::parse($dateStart)
            ->toDateTimeString();
        $data['end'] = Carbon::parse($dateEnd)
            ->toDateTimeString();
        if(Task::create($data)){
            return true;
        } else{
            return false;
        }
	}
    public function updateElement($event ,$request) {
//        $event = Task::where('id', $id);
        $data = $request->toArray();
        $dateStart = $request->start;
        $dateEnd = $request->end;
        $data['start'] = Carbon::parse($dateStart)
            ->toDateTimeString(); // 2018-09-29 00:00:00;
        $data['end'] = Carbon::parse($dateEnd)
            ->toDateTimeString(); // 2018-09-29 00:00:00;

        if($event->update($data)){
            return true;
        } else{
            return false;
        }
    }

    public function destroyElement($id) {
        $event = Task::find($id);
        if($event->delete()){
            return true;
        } else{
            return false;
        }
    }
}
