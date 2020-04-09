@extends('crm.outgoing_documents.general')

@section('css')
	<style>
		#dtListElements tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('content_content')
		@if(isset($createLink) and auth()->user()->can('create_' . $permissionKey))
			<div class="col-12 row mb-3">
				<a href="{{ $createLink }}" class="btn btn-primary " >{{ __('references.main.create_element') }}</a>
			</div>
		@endif

        @include('crm.outgoing_documents.filter_listelemnts')

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

    <script src="{{ asset('/js/datatable_export_excel.js') }}"></script>
@stop
