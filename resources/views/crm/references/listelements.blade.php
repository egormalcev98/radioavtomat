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
							<a href="{{ $createLink }}" class="btn btn-primary " >{{ __('references.main.create_element') }}</a>
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

@section('js')
	{!! $datatable->scripts() !!}
@stop