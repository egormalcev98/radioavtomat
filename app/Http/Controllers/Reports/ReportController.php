<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reports\ReportService as Service;

class ReportController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
        $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}
	
	public function index()
    {
		$with = $this->service->outputData();
		
		if(!is_array($with)) {
			return $with;
		}
		
		$with['title'] = __($this->service->translation . 'index.title');
		
		return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }
}
