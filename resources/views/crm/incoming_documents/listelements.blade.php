@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('css')
	@if(auth()->user()->can('view_incoming_card_document'))
		<style>
			#dtListElements tbody tr {
				cursor: pointer;
			}
		</style>
	@endif
@stop

@section('content')
	@include('crm.listelements.structure'/*, ['filterTemplate']*/)
@stop

@section('js')
	{!! $datatable->scripts() !!}
	
	@if(auth()->user()->can('view_incoming_card_document'))
		<script type="text/javascript">
			$('#dtListElements tbody').on('click', 'tr', function(event){
				if(event.target.nodeName == 'TD') {
					
					let data = window.LaravelDataTables["dtListElements"].row( this ).data();
					location.href = data['showUrl'];
				}
			});
		</script>
	@endif
@stop