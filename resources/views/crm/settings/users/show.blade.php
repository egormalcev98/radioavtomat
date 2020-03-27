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
				<fieldset disabled="true">
				
					@include('crm.settings.users.form_elements')
					
				</fieldset>
            </div>
            <!-- /.card -->
		</div>
	</div>
@stop


@section('js')
	<script type="text/javascript">
		$(document).ready(function () {
			$('.select2').attr('disabled', true);
		});
	</script>
@stop