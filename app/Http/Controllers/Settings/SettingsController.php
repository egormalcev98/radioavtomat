<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use App\Services\Settings\SettingsService as Service;
use App\Http\Requests\Settings\UpdateRequest;

class SettingsController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
		
		// $this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(!auth()->user()->can('view_' . $this->service->permissionKey)){
			if(auth()->user()->can('view_user')) {
				return redirect()->route('users.index');
			}
			
			return abort(403);
		}
		
        $with = $this->service->outputData();
		
        return view($this->service->templatePath . $this->service->templateForm)->with($with);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $this->service->update($request);
		
		flash(__('settings.msg.success_update'))->success();
		
		return redirect()->route($this->service->routeName . '.index');
    }

}
