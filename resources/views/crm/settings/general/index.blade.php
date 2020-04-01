@extends('crm.settings.tabs')

@section('tab_content')		
	<form class="form-horizontal" role="form" method="POST" action="{{ route('settings.update', 's') }}" enctype="multipart/form-data">
        @csrf
		{{ method_field('PATCH') }}
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">{{ __('validation.attributes.name_org') }}</label>
			<div class="col-sm-10">
				<input type="text" name="name_org" class="form-control {{ $errors->has('name_org') ? 'is-invalid' : '' }}" @if($settings) value="{{ $settings->name_org }}" @else value="{{ old('name_org') }}" @endif >
				@include('crm.error_message', ['nameField' => 'name_org'])
			</div>
		</div>
		<div class="form-group row">
			<label  class="col-sm-2 col-form-label">{{ __('validation.attributes.name_sys') }}</label>
			<div class="col-sm-10">
				<input type="text" name="name_sys" class="form-control {{ $errors->has('name_sys') ? 'is-invalid' : '' }}" @if($settings) value="{{ $settings->name_sys }}" @else value="{{ old('name_sys') }}" @endif>
				@include('crm.error_message', ['nameField' => 'name_sys'])
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">{{ __('validation.attributes.logo_img') }}</label>
			<div class="col-sm-10">
				<div class="custom-file">
                    <input type="file" name="logo_img" class="custom-file-input {{ $errors->has('logo_img') ? 'is-invalid' : '' }}" id="logo_img">
					@include('crm.error_message', ['nameField' => 'logo_img'])
                    <label class="custom-file-label" for="logo_img">145x145 px</label>
                </div>
				@if($settings and $settings->logo_img)
					<img src="{{ Storage::url($settings->logo_img) }}" style="border: 1px solid #000000; margin-top: 10px;" >
				@endif
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">{{ __('validation.attributes.background_img') }}</label>
			<div class="col-sm-10">
				<div class="custom-file">
                    <input type="file" name="background_img" class="custom-file-input {{ $errors->has('background_img') ? 'is-invalid' : '' }}" id="background_img">
					@include('crm.error_message', ['nameField' => 'background_img'])
                    <label class="custom-file-label" for="background_img">1920x1080 px</label>
                </div>
				@if($settings and $settings->background_img)
					<img src="{{ Storage::url($settings->background_img) }}" style="border: 1px solid #000000; margin-top: 10px; max-width: 150px;" >
				@endif
			</div>
		</div>
		<div class="form-group row">
			<label  class="col-sm-2 col-form-label">{{ __('validation.attributes.admin.email') }}</label>
			<div class="col-sm-10">
				<input type="email" required="true" name="admin[email]" class="form-control {{ $errors->has('admin.email') ? 'is-invalid' : '' }}" @if($admin) value="{{ $admin->email }}" @else value="{{ old('admin.email') }}" @endif>
				@include('crm.error_message', ['nameField' => 'admin.email'])
			</div>
		</div>
		<div class="form-group row">
			<label  class="col-sm-2 col-form-label">{{ __('validation.attributes.admin.password') }}</label>
			<div class="col-sm-10">
				<input type="password" name="admin[password]" class="form-control {{ $errors->has('admin.password') ? 'is-invalid' : '' }}" >
				@include('crm.error_message', ['nameField' => 'admin.password'])
			</div>
		</div>
		@if(auth()->user()->can('update_' . $permissionKey))
			<button type="submit" class="btn btn-primary">Сохранить</button>
		@endif
	</form>
@stop

@section('js')
	<script src="{{ asset('/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			bsCustomFileInput.init();
		});
	</script>
@stop