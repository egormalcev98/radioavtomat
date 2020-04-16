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
	@include('crm.listelements.structure', ['filterTemplate' => 'incoming_documents.filter_listelements', 'tableParams' => ['class' => 'small table table-hover dataTable no-footer', 'style' => 'width:100%;']])
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
	
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#dtListElements').dataTable().fnSettings().aoRowCallback.push( {
				"fn": function (nRow, aData, iDisplayIndex) {
					if(aData['urgent'] == 1){
						$(nRow).css('background', '#f9caca');
					}
				}
			} );
			
			$('#period').daterangepicker({
				'opens': 'right',
				'locale': Main.confDrp,
				'autoUpdateInput': false
			}, function(start_date, end_date) {
				this.element.val(start_date.format(Main.confDrp.format) + ' - ' + end_date.format(Main.confDrp.format)).change();
			});
		});
	</script>
@stop