<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Activity\ActivityService as Service;

class ActivityController extends Controller
{
    public function __construct(Service $service)
    {
        $this->service = $service;

//        $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index', 'show']]);
//        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);

        view()->share('permissionKey', $this->service->permissionKey);

    }

    public function index()
    {
        if (request()->ajax()) {
            return $this->service->dataTableData();
        }

        $with = $this->service->outputData();

        $with['title'] = __($this->service->translation . 'index.title');
        $with['datatable'] = $this->service->constructViewDT();

        return view($this->service->templatePath . 'listelements')->with($with);
    }

}
