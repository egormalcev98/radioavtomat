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
				<form role="form" method="POST" action="" >
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
					</div>
					
					@include('crm.box_footer')
					
				</form>
            </div>
            <!-- /.card -->
		</div>
	</div>
@stop