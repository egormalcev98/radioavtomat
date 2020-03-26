	
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
						@include('crm.' . $filterTemplate)
					@endif
					
					{!! $datatable->table(['class' => 'table table-striped table-bordered table-hover dataTable no-footer'], true) !!}
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>