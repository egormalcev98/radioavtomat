	<div class="col-3">
		<div class="form-group">
			<label>Выберите дату</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-calendar"></i></span>
				</div>
				<input onchange="Main.updateDataTable(event);" type="text" class="form-control pull-right" id="period" name="period" autocomplete="off">
			</div>
		</div>
	</div>

	<div class="col-3">
		<div class="form-group">
			<label>Вид документа</label>
			<select onchange="Main.updateDataTable(event);" class="form-control select2" name="document_type_id">
				<option value="">Ничего не выбрано</option>
				@if($documentTypes->isNotEmpty())
					@foreach($documentTypes as $documentType)
						<option value="{{ $documentType->id }}">{!! $documentType->name !!}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>
	
	<div class="col-3">
		<div class="form-group">
			<label>Статус документа</label>
			<select onchange="Main.updateDataTable(event);" class="form-control select2" name="incoming_doc_status_id">
				<option value="">Ничего не выбрано</option>
				@if($incomingDocStatuses->isNotEmpty())
					@foreach($incomingDocStatuses as $incomingDocStatus)
						<option value="{{ $incomingDocStatus->id }}">{!! $incomingDocStatus->name !!}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>
	
	<div class="col-1">
		<label>&nbsp;</label>
		<button type="button" class="btn btn-block btn-secondary"><i class="fas fa-print"></i></button>
	</div>
	
	<div class="col-2">
		<label>&nbsp;</label>
		<button type="button" class="btn btn-block btn-warning">История</button>
	</div>