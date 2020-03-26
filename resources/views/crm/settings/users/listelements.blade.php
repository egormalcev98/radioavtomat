@extends('crm.settings.tabs')

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
			{!! $datatable->table(['class' => 'table table-hover dataTable no-footer'], true) !!}
		</div>
@stop

@section('js')
	{!! $datatable->scripts() !!}
@stop