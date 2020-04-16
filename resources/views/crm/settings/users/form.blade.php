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

					@include('crm.settings.users.form_elements')

					@include('crm.box_footer')

				</form>
            </div>
            <!-- /.card -->
		</div>
	</div>
@stop
