	
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
						@include('crm.' . $filterTemplate)
					@endif
					
					<div class="p-0">
						{!! $datatable->table($tableParams ?? []) !!}
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>