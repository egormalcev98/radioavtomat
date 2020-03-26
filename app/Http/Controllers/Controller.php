<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $service;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if (request()->ajax()) {
			return $this->service->dataTableData();
		}
		
		$with = $this->service->outputData();
		
		$with['title'] = __($this->service->translation . 'index.title');
		$with['datatable'] = $this->service->constructViewDT();
		$with['createLink'] = route($this->service->routeName . '.create');
		
		return view($this->service->templatePath . 'listelements')->with($with);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$with = $this->service->elementData();
		
		$with['title'] = __($this->service->translation . 'index.title') . ': ' . __('references.main.create_text_template');
		$with['action'] = route($this->service->routeName . '.store');
		$with['method'] = __FUNCTION__;
		
		return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }
	
}
