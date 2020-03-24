<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use App\Services\Settings\SettingsService as Service;

class SettingsController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $with = $this->service->outputData();
		
        return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}
