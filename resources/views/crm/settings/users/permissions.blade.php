@extends('adminlte::page')

@section('title', 'Настройка прав доступа')

@section('content_header')
    <h1>Настройка прав доступа</h1>
@stop

@section('content')
	<div class="row">
        <!-- left column -->
        <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
				<form role="form" method="POST" action="{{ route('users.permissions_save', $user->id) }}" >
					@csrf
					{{ method_field('PATCH') }}
					
					<div class="card-body row">
						<div class="col-12">
							<div class="form-group">
								<label>ID</label>
								<input type="text" disabled="true" class="form-control" value="{{ $user->id }}">
							</div>
							<div class="form-group">
								<label>Фамилия</label>
								<input type="text" disabled="true" class="form-control" value="{{ $user->surname }}">
							</div>
							<div class="form-group">
								<label>Имя</label>
								<input type="text" disabled="true" class="form-control" value="{{ $user->name }}">
							</div>
							<div class="form-group">
								<label>Отчество</label>
								<input type="text" disabled="true" class="form-control" value="{{ $user->middle_name }}">
							</div>
						</div>
						
						<div class="col-12 form-horizontal">
							<h4 class="form-group">Доступы</h4>

							@if(!empty($permissionModules))
								@foreach($permissionModules as $module)
									<div class="form-group row">
										<div class="col-3 col-form-label">
											<label class="control-label">@if(isset($module['lang_title']))@lang($module['lang_title']) @else {{ $module['title'] }} @endif</label>
										</div>
										<div class="col-3">
											@if(!empty($permissionTypes))
												<select class="form-control" name="permission_modules[{{ $module['name'] }}]">
													@foreach($permissionTypes as $key => $type)
														<option @if(isset($module['list_types']) and $module['list_types'] == $key) selected @endif value="{{ $key }}" >@lang($type['title'])</option>
													@endforeach
												</select>
											@endif
										</div>
									</div>
								@endforeach
							@endif
						</div>
						
					</div>
					
					@include('crm.box_footer')
					
				</form>
            </div>
            <!-- /.card -->
		</div>
	</div>
@stop