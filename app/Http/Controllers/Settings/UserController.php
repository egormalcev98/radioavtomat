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
		
		$this->middleware('permission:view_' . $this->service->permissionKey, ['only' => ['index', 'show']]);
        $this->middleware('permission:create_' . $this->service->permissionKey, ['only' => ['create', 'store']]);
        $this->middleware('permission:update_' . $this->service->permissionKey, ['only' => ['update', 'permissionsSave']]);
        $this->middleware('permission:read_' . $this->service->permissionKey, ['only' => ['edit', 'permissions']]);
        $this->middleware('permission:delete_' . $this->service->permissionKey, ['only' => ['destroy']]);
		
		view()->share('permissionKey', $this->service->permissionKey);
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
        $with = $this->service->userPermissionsData();
		
		return view($this->service->templatePath . 'permissions')->with($with);
    }

    /**
     * Save the permissions resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function permissionsSave(Request $request, User $user)
    {
        $this->service->model = $user;
        $this->service->userPermissionsSave($request);
		
		return $this->successfulElementUpdate($this->service->routeName, $user->id);
    }
}
