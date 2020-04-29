<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreOrUpdateOrderRequest;
use App\Http\Requests\Tasks\StoreOrUpdateTaskRequest;
use App\Models\Tasks\Task;
use App\Services\Tasks\TaskService as Service;
use Illuminate\Http\Request;


class TaskController extends Controller
{

    public function __construct(Service $service)
    {
        $this->middleware('permission:orders_access', ['only' => ['storeOrder', 'updateOrder']]);
        $this->middleware('task_owner', ['only' => ['edit', 'updateTask', 'updateOrder', 'destroy']]);

        $this->service = $service;

    }

    public function index()
    {
        $with = $this->service->outputData();
        $with['title'] = __($this->service->translation . 'index.title');

        return view($this->service->templatePath . 'index')->with($with);
    }

    public function create()
    {
        if (isset($_GET['type'])) {
            return $this->service->createTask($_GET['type']);
        }

        return abort(403);
    }

    public function storeTask(StoreOrUpdateTaskRequest $request)
    {
        return $this->service->storeOrUpdateTask($request, 1);
    }

    public function storeOrder(StoreOrUpdateOrderRequest $request)
    {
        return $this->service->storeOrUpdateTask($request, 2);
    }

    public function edit(Task $task)
    {
        return $this->service->editTask($task);
    }

    public function updateTask(StoreOrUpdateTaskRequest $request, Task $task)
    {
        return $this->service->storeOrUpdateTask($request, null, $task);
    }

    public function updateOrder(StoreOrUpdateOrderRequest $request, Task $task)
    {
        return $this->service->storeOrUpdateTask($request, null, $task);
    }

    public function getTasks()
    {
        return response()->json($this->service->getTasks(request()));
    }

    public function taskInfo(Task $task)
    {
        if (request()->ajax()) {

            return $this->service->taskInfo($task);
        }
    }

    public function destroy(Task $task)
    {
        if ($this->service->destroyElement($task)) {
            return response()->json(['status' => 'true']);
        } else {
            return response()->json(['status' => 'false']);
        }
    }

    public function getWeeks(Request $request)
    {
        if (request()->ajax()) {

            return $this->service->getWeeks($request);
        }
    }

    // это чтобы отмечать что уведомление о задачи просмотрено
    public function doCompleted(Task $task)
    {
        return $this->service->doCompleted($task);
    }
}
