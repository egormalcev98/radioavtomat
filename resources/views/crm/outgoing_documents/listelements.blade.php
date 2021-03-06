@extends('crm.outgoing_documents.general')

@section('css')
    @if(auth()->user()->can('view_outgoing_card_document'))
        <style>
            #dtListElements tbody tr {
                cursor: pointer;
            }
        </style>
    @endif
@stop

@section('content_content')
    @include('crm.listelements.structure', ['filterTemplate' => 'outgoing_documents.filter_listelemnts', 'tableParams' => ['class' => 'small table table-hover dataTable no-footer', 'style' => 'width:100%;']])
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
