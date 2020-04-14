	<div class="card-body row">
		<div class="col-12">
			<div class="form-group">
				<label>{{ __('validation.attributes.title') }}</label>
				<input type="text" required="true" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') ?? $incomingDocument->title ?? '' }}" >
				@include('crm.error_message', ['nameField' => 'title'])
			</div>
			<div class="form-group">
				<label>{{ __('validation.attributes.incoming_doc_status_id') }}</label>
				<select class="form-control select2 {{ $errors->has('incoming_doc_status_id') ? 'is-invalid' : '' }}" name="incoming_doc_status_id" required="required" style="width: 100%;">
					@if($incomingDocStatuses->isNotEmpty())
						@foreach($incomingDocStatuses as $incomingDocStatus)
							<option value="{{ $incomingDocStatus->id }}" @if((@old('incoming_doc_status_id') ?? $incomingDocument->incoming_doc_status_id ?? 0) == $incomingDocStatus->id) selected @endif >{{ $incomingDocStatus->name }}</option>
						@endforeach
					@endif
				</select>
				@include('crm.error_message', ['nameField' => 'incoming_doc_status_id'])
			</div>
			<div class="form-group">
				<label>{{ __('validation.attributes.document_type_id') }}</label>
				<select class="form-control select2 {{ $errors->has('document_type_id') ? 'is-invalid' : '' }}" name="document_type_id" required="required" style="width: 100%;">
					@if($documentTypes->isNotEmpty())
						@foreach($documentTypes as $documentType)
							<option value="{{ $documentType->id }}" @if((@old('document_type_id') ?? $incomingDocument->document_type_id ?? 0) == $documentType->id) selected @endif >{{ $documentType->name }}</option>
						@endforeach
					@endif
				</select>
				@include('crm.error_message', ['nameField' => 'document_type_id'])
			</div>
			<div class="form-group">
				<div class="form-check">
					<input id="urgent_checkbox" class="form-check-input" type="checkbox" value="1" name="urgent" @if((@old('urgent') ?? $incomingDocument->urgent ?? 0) == 1) checked="true" @endif >
					<label for="urgent_checkbox" class="form-check-label">{{ __('validation.attributes.urgent') }}</label>
				</div>
			</div>
			
			<div class="col-12 row">
				<div class="col-6">
					<h4 class="text-center">Отправитель</h4>
					<div class="form-group">
						<label>{{ __('validation.attributes.counterparty') }}</label>
						<input type="text" required="true" class="form-control {{ $errors->has('counterparty') ? 'is-invalid' : '' }}" name="counterparty" value="{{ old('counterparty') ?? $incomingDocument->counterparty ?? '' }}" >
						@include('crm.error_message', ['nameField' => 'counterparty'])
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.number') }}</label>
						<div class="input-group">
							<input type="number" id="number_incoming_doc" required="true" class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number" value="{{ old('number') ?? $incomingDocument->number ?? '' }}" >
							@if($method == 'create')
								<div class="input-group-append">
									<button type="button" class="input-group-text" data-toggle="tooltip" data-placement="top" title="Проверить на повторную регистарцию" onclick="IncomingDocument.checkNumber($(this), '{{ route('incoming_documents.check_number') }}');" >Проверить</button>
								</div>
							 @endif
							@include('crm.error_message', ['nameField' => 'number'])
						</div>
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.date_letter_at') }}</label>
						<input type="date" class="form-control {{ $errors->has('date_letter_at') ? 'is-invalid' : '' }}" name="date_letter_at" value="{{ old('date_letter_at') ?? $incomingDocument->date_letter_server_at ?? '' }}" >
						@include('crm.error_message', ['nameField' => 'date_letter_at'])
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.from') }}</label>
						<input type="text" required="true" class="form-control {{ $errors->has('from') ? 'is-invalid' : '' }}" name="from" value="{{ old('from') ?? $incomingDocument->from ?? '' }}" >
						@include('crm.error_message', ['nameField' => 'from'])
					</div>
				</div>
				<div class="col-6">
					<h4 class="text-center">Регистрация</h4>
					<div class="form-group">
						<label>{{ __('validation.attributes.date_delivery_at') }}</label>
						<div class="input-group">
							<input type="date" class="form-control {{ $errors->has('date_delivery_at') ? 'is-invalid' : '' }}" name="date_delivery_at" value="{{ old('date_delivery_at') ?? $incomingDocument->date_delivery_server_at ?? '' }}" >
							<div class="input-group-append">
								<span class="input-group-text">
									<input id="original_received_checkbox" type="checkbox" name="original_received" value="1" @if((@old('original_received') ?? $incomingDocument->original_received ?? 0) == 1) checked="true" @endif  data-toggle="tooltip" data-placement="top" title="{{ __('validation.attributes.original_received') }}" >
								</span>
							</div>
							@include('crm.error_message', ['nameField' => 'date_delivery_at'])
						</div>
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.register') }}</label>
						<div class="input-group">
							<input type="number" class="form-control {{ $errors->has('register') ? 'is-invalid' : '' }}" name="register" value="{{ old('register') ?? $incomingDocument->register ?? '' }}" >
							@if($method == 'create')
								<div class="input-group-append">
									<span class="input-group-text">
										<input name="register_automatic" type="checkbox" value="1" data-toggle="tooltip" data-placement="top" title="Автоматически присвоить номер" @if(@old('register_automatic') == 1) checked="true" @endif >
									</span>
								</div>
							@endif
							@include('crm.error_message', ['nameField' => 'register'])
						</div>
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.number_pages') }}</label>
						<input type="number" required="true" class="form-control {{ $errors->has('number_pages') ? 'is-invalid' : '' }}" name="number_pages" value="{{ old('number_pages') ?? $incomingDocument->number_pages ?? '' }}" >
						@include('crm.error_message', ['nameField' => 'number_pages'])
					</div>
					<div class="form-group">
						<label>{{ __('validation.attributes.recipient_id') }}</label>
						<select class="form-control select2 {{ $errors->has('recipient_id') ? 'is-invalid' : '' }}" name="recipient_id">
							<option value="">Ничего не выбрано</option>
							@if($recipients->isNotEmpty())
								@foreach($recipients as $recipient)
									<option value="{{ $recipient->id }}" @if((@old('recipient_id') ?? $incomingDocument->recipient_id ?? 0) == $recipient->id) selected @endif >{{ $recipient->fullName }}</option>
								@endforeach
							@endif
						</select>
						@include('crm.error_message', ['nameField' => 'recipient_id'])
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>{{ __('validation.attributes.note') }}</label>
				<textarea name="note" class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="4" >{{ old('note') ?? $incomingDocument->note ?? '' }}</textarea>
				@include('crm.error_message', ['nameField' => 'note'])
			</div>
		</div>
	</div>