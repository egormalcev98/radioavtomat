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

//        $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
//        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);

        view()->share('permissionKey', $this->service->permissionKey);

    }

    public function index()
    {
        if (request()->ajax()) {
            $result = $this->service->tableData(request()->all());
            $with['tableData'] = $result[0];
            $with['paginator'] = $result[1];

            return view($this->service->templatePath . 'listelements')->with($with);
        }
        $result = $this->service->tableData();
        $with['tableData'] = $result[0];
        $with['paginator'] = $result[1];

        $with['title'] = __($this->service->translation . 'index.title');

        return view($this->service->templatePath . 'general')->with($with);
    }

}
