	
	<div class="row">
		<div class="col-12">
			<div class="card">
					@if(isset($createLink) and (!isset($permissionKey) or auth()->user()->can('create_' . $permissionKey)))
						<div class="card-header">
							<div class="col-1">
								<a href="{{ $createLink }}" class="btn btn-primary" >{{ __('references.main.create_element') }}</a>
							</div>
						</div>
					@endif
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