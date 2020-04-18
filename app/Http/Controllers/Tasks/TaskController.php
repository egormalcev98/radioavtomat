<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreRequest;
use App\Models\Tasks\Task;
use App\Services\Tasks\TaskService as Service;
use Illuminate\Http\Request;


class TaskController extends Controller
{

    public function __construct(Service $service) {

        $this->service = $service;

    }

    public function index($page = null)
    {
        $with = $this->service->outputData($page);
        return view($this->service->templatePath . 'index')->with($with);
    }

    public function create()
    {
        return __METHOD__;
        return $this->createElement();
    }

    public function store(StoreRequest $request)
    {
        return __METHOD__;
//        return $this->storeElement($request);
		if ($this->storeElement($request)) {
            return response()->json(['status' => 'true']);
        } else {
            return response()->json(['status' => 'false']);
        }
    }

    public function edit(Task $task)
    {
        return __METHOD__;
        return $this->editElement($task);
    }

    public function update(Task $task, Request $request)
    {
        return __METHOD__;
        if ($this->service->updateElement($task, $request)) {
            return response()->json(['status' => 'true']);
        } else {
            return response()->json(['status' => 'false']);
        }
    }
	public function getTasks()
    {

       return response()->json($this->service->getTasks(request()));
    }

//    public function destroy($id)
//    {
//        if ($this->service->destroyElement($id)){
//            return response()->json(['status' => 'true']);
//        } else {
//            return response()->json(['status' => 'false']);
//        }
//    }
}
