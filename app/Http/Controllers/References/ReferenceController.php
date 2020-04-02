<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\References\BaseRequest;

class ReferenceController extends Controller
{
    public function __construct($service) {
		$this->service = $service;
		
		$this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
        $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['store']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update']]);
        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return abort(404);
    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BaseRequest $request)
    {
		return $this->ajaxStoreElement($request);
    }
}
