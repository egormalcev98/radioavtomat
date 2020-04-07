
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					@if(isset($createLink))
						<div class="col-1">
							<a href="{{ $createLink }}" class="btn btn-primary" >{{ __('references.main.create_element') }}</a>
						</div>
					@endif
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@if(isset($filterTemplate))
						<div class="col-12 row" id="dt_filters">
							@include('crm.' . $filterTemplate)
						</div>
					@endif

					<div class="p-0">
						{!! $datatable->table() !!}
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
