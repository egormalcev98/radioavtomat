@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

	<div class="row">
		<!-- general form elements -->
		<div class="col-12 row">
			<div class="col-8">
				<div class="card card-primary">
				  <!-- form start -->
				  
					<fieldset disabled="true">
						@include('crm.incoming_documents.form_elements')
					</fieldset>
					
				</div>
			</div>
			<div class="col-4">
				<div class="card">
					<div class="card-body row">
						<table class="table table-bordered table-sm">
							@include('crm.incoming_documents.file_table_head')
							<tbody>
								@if(isset($incomingDocumentFiles) and $incomingDocumentFiles->isNotEmpty())
									@foreach($incomingDocumentFiles as $incomingDocumentFile)
										<tr>@include('crm.incoming_documents.file_template', ['dataFile' => $incomingDocumentFile,  'disableActions' => true])</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /.card -->
		</div>
		
		@if($viewResponse)
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Рассмотрение документа ответственными</h3>
					</div>
					<div class="card-body row">
						@if(auth()->user()->hasRole('Подпись или чего там'))
							<div class="col-12 row">
								<div class="col-4">
									<div class="form-group">
										<label>{{ __('validation.attributes.signed_at') }}</label>
										<div class="input-group">
											<input type="date" class="form-control" name="signed_at" value="" >
											<div class="input-group-append">
												<span class="input-group-text">
													<input type="checkbox" value="1" data-toggle="tooltip" data-placement="top" title="Отправить на подпись документ" >
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label>{{ __('validation.attributes.reject_at') }}</label>
										<div class="input-group">
											<input type="date" class="form-control" name="reject_at" value="" >
											<div class="input-group-append">
												<span class="input-group-text">
													<input type="checkbox" value="1" data-toggle="tooltip" data-placement="top" title="Отклонить документ" >
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="info-box" style="min-height: 70px;">
										<div class="info-box-content">
											<h5>Процент рассмотрения</h5>
										</div>
										<span class="info-box-icon bg-info">75</span>
									</div>
								</div>
							</div>
						@endif
						@if($viewResponse)
							<div class="col-12 row">
								<div class="col-6">
									<div class="mb-5">
										<h4 class="float-left">Кому распределено</h4>
										<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_distributed" >Добавить</button>
									</div>
									
									{!! $datatableDistributed->table(['id' => 'dtListDistributed']) !!}
										
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		@endif
	</div>
@stop

@section('js')
	
	@if($viewResponse)
		@include('crm.incoming_documents.modal_distributed')
	@endif

	<script src="{{ asset('/js/incoming_document.js') }}"></script>
	
	{!! $datatableDistributed->scripts() !!}
	
	<script type="text/javascript">
		$(document).ready(function () {
			$('fieldset .select2').attr('disabled', true);
		});
	</script>
@stop