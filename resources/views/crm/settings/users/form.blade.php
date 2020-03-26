@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="row">
        <!-- left column -->
        <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
				<form role="form" method="POST" action="{{ $action }}" >
					@csrf
					@if($method == 'edit')
						{{ method_field('PATCH') }}
					@endif
					<div class="card-body">
						<div class="col-6">
							@if($method == 'edit')
								<div class="form-group">
									<label>ID</label>
									<input type="text" class="form-control" value="{{ $user->id }}">
								</div>
								<div class="form-group">
									<label>Дата регистрации</label>
									<input type="text" class="form-control" value="{{ $user->created_at }}">
								</div>
							@endif
							<div class="form-group">
								<label>{{ __('validation.attributes.user_status_id') }}</label>
								<select class="form-control select2" name="user_status_id" required="required" >
									@if($userStatuses->isNotEmpty())
										@foreach($userStatuses as $userStatus)
											<option value="{{ $userStatus->id }}" @if((@old('user_status_id') and @old('user_status_id') == $userStatus->id) or ($method == 'edit' and $user->user_status_id == $userStatus->id)) selected @endif >{{ $userStatus->name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'user_status_id'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.email') }}</label>
								<input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" @if($method == 'edit') value="{{ $user->email }}" @else value="{{ old('email') }}" @endif >
								@include('crm.error_message', ['nameField' => 'email'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.password') }}</label>
								<input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" >
								@include('crm.error_message', ['nameField' => 'password'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.structural_unit_id') }}</label>
								<select class="form-control select2" name="structural_unit_id" required="required" >
									@if($structuralUnits->isNotEmpty())
										@foreach($structuralUnits as $structuralUnit)
											<option value="{{ $structuralUnit->id }}" @if((@old('structural_unit_id') and @old('structural_unit_id') == $structuralUnit->id) or ($method == 'edit' and $user->structural_unit_id == $structuralUnit->id)) selected @endif >{{ $structuralUnit->name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'structural_unit_id'])
							</div>
							<div class="form-group">
								<label>{{ __('validation.attributes.role') }}</label>
								<select class="form-control select2" name="role" required="required" >
									@if($roles->isNotEmpty())
										@foreach($roles as $role)
											<option value="{{ $role->id }}" @if((@old('role') and @old('role') == $role->id) or ($method == 'edit' and $user->role == $role->id)) selected @endif >{{ $role->display_name }}</option>
										@endforeach
									@endif
								</select>
								@include('crm.error_message', ['nameField' => 'role'])
							</div>
						</div>
					</div>
					<!-- /.card-body -->
					
					@include('crm.box_footer')
					
				</form>
            </div>
            <!-- /.card -->
		</div>
	</div>
@stop