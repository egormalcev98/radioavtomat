@extends('crm.settings.tabs')

@section('css')
	<style>
		#dtListElements tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('tab_content')		
		@if(isset($createLink) and auth()->user()->can('create_' . $permissionKey))
			<div class="col-12 row mb-3">
				<a href="{{ $createLink }}" class="btn btn-primary " >{{ __('references.main.create_element') }}</a>
			</div>
		@endif
		
		<div class="col-12 row" id="dt_filters">
			@include('crm.settings.users.filter_listelemnts')
		</div>
		
		<div class="p-0">
			{!! $datatable->table() !!}
		</div>
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