@extends('crm.settings.tabs')

@section('css')
	<style>
		#dtListElements tbody tr {
			cursor: pointer;
		}
	</style>
@stop

@section('tab_content')		
		@if(isset($createLink))
			<div class="col-12 row mb-3">
				<a href="{{ $createLink }}" class="btn btn-primary " >{{ __('references.main.create_element') }}</a>
			</div>
		@endif
		
		{{--
		@if(isset($filterTemplate))
			@include('crm.' . $filterTemplate)
		@endif
		--}}
		
		<div class="p-0">
			{!! $datatable->table() !!}
		</div>
@stop

@section('js')
	{!! $datatable->scripts() !!}
	<script type="text/javascript">
		$('#dtListElements tbody').on('click', 'tr', function(){
			let data = window.LaravelDataTables["dtListElements"].row( this ).data();
			
			location.href = data['showUrl'];
		});
	</script>
@stop