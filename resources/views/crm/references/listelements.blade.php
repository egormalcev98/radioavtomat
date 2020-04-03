@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				@if(isset($createLink) and auth()->user()->can('create_' . $permissionKey))
					<div class="card-header">
						<div class="col-12 row">
							<button type="button" class="btn btn-primary" onclick="Main.createModalReferences('{{ $action }}', '#modal_element');" >{{ __('references.main.create_element') }}</button>
						</div>
					</div>
				@endif
				
				<!-- /.card-header -->
				<div class="card-body">
					<div class="p-0">
						{!! $datatable->table() !!}
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
@stop

@if(auth()->user()->can('create_' . $permissionKey))
	@section('modal')
		@section('modal_title', 'Данные')
		@section('modal_id', 'modal_element')
		<form role="form" method="POST" onsubmit="Main.sendFormDataReferences(event, $(this));" action="" >
			@csrf
			<div class="modal-body">
				@include($templateElement)
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('references.main.close_button') }}</button>
				<button type="submit" class="btn btn-primary">{{ __('references.main.save_button') }}</button>
			</div>
		</form>
	@stop
@endif

@section('js')
	{!! $datatable->scripts() !!}
@stop