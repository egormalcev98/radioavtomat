<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Services\Settings\UserService as Service;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UpdateRequest;

class UserController extends Controller
{
    public function __construct(Service $service) {
		$this->service = $service;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeElement($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showElement($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $this->editElement($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        return $this->updateElement($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
		if($user->hasRole('admin')) {
			return abort(404);
		}
		
        return $this->destroyElement($user);
    }
	
    /**
     * Show the form for permissions the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function permissions(User $user)
    {
		$this->service->model = $user;
        $with = $this->service->elementPermissionsData();
		
		return view($this->service->templatePath . 'permissions')->with($with);
    }

}
