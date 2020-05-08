<?php

namespace App\Http\Controllers\TodayJobs;

use Illuminate\Http\Request;
use App\Services\TodayJobs\TodayJobsService as Service;

class TodayJobController
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->service->rewriteTodayJobs();
        $with['todayJobs'] = $this->service->getTodayJobs();
        $with['title'] = __($this->service->translation . 'index.title');

        return view($this->service->templatePath . 'index')->with($with);
    }

}
