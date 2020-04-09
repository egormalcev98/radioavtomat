@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('css')
	<style>
		#dtListElements tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('content')
	@include('crm.listelements.structure'/*, ['filterTemplate']*/)
@stop

@section('js')
	{!! $datatable->scripts() !!}
	
	<script type="text/javascript">
		$('#dtListElements tbody').on('click', 'tr', function(event){
			if(event.target.nodeName == 'TD') {
				
				let data = window.LaravelDataTables["dtListElements"].row( this ).data();
				location.href = data['showUrl'];
			}
		});
	</script>
@stop