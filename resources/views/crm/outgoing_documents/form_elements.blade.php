<!-- left column -->
<!-- general form elements -->
<div class="col-12 row">
    <div class="col-9">
        <div class="card card-primary">
            <!-- form start -->
            <div class="card-body row">
                <div class="col-12">
                    <div class="col-12 row">
                        <div class="col-6">
                            <h4 class="text-center">&nbsp;</h4>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.letter_form_id') }}</label>
                                <select
                                    class="form-control select2 {{ $errors->has('letter_form_id') ? 'is-invalid' : '' }}"
                                    name="letter_form_id" required="required">
                                    @if($letterForms->isNotEmpty())
                                        @foreach($letterForms as $letterForm)
                                            <option value="{{ $letterForm->id }}"
                                                    @if((@old('letter_form_id') ?? $outgoingDocument->letter_form_id ?? 0) == $letterForm->id) selected @endif >{{ $letterForm->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @include('crm.error_message', ['nameField' => 'letter_form_id'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.title') }}</label>
                                <input type="text" required="true"
                                       class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"
                                       value="{{ old('title') ?? $outgoingDocument->title ?? '' }}">
                                @include('crm.error_message', ['nameField' => 'title'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.outgoing_doc_status_id') }}</label>
                                <select
                                    class="form-control select2 {{ $errors->has('outgoing_doc_status_id') ? 'is-invalid' : '' }}"
                                    name="outgoing_doc_status_id" required="required">
                                    @if($outgoingDocStatuses->isNotEmpty())
                                        @foreach($outgoingDocStatuses as $outgoingDocStatus)
                                            <option value="{{ $outgoingDocStatus->id }}"
                                                    @if((@old('outgoing_doc_status_id') ?? $outgoingDocument->outgoing_doc_status_id ?? 0) == $outgoingDocStatus->id) selected @endif >{{ $outgoingDocStatus->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @include('crm.error_message', ['nameField' => 'outgoing_doc_status_id'])
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>{{ __('validation.attributes.document_type_id') }}</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('document_type_id') ? 'is-invalid' : '' }}"
                                            name="document_type_id" required="required">
                                            @if($documentTypes->isNotEmpty())
                                                @foreach($documentTypes as $documentType)
                                                    <option value="{{ $documentType->id }}"
                                                            @if((@old('document_type_id') ?? $outgoingDocument->document_type_id ?? 0) == $documentType->id) selected @endif >{{ $documentType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @include('crm.error_message', ['nameField' => 'document_type_id'])
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ __('validation.attributes.number_pages') }}</label>
                                        <input type="number" required="true"
                                               class="form-control {{ $errors->has('number_pages') ? 'is-invalid' : '' }}"
                                               name="number_pages"
                                               value="{{ old('number_pages') ?? $outgoingDocument->number_pages ?? '' }}">
                                        @include('crm.error_message', ['nameField' => 'number_pages'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-center">Получатель</h4>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.counterparty') }}</label>
                                <input type="text" required="true"
                                       class="form-control {{ $errors->has('counterparty') ? 'is-invalid' : '' }}"
                                       name="counterparty"
                                       value="{{ old('counterparty') ?? $outgoingDocument->counterparty ?? '' }}">
                                @include('crm.error_message', ['nameField' => 'counterparty'])
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <label>{{ __('validation.attributes.number') }}</label>
                                        <div class="input-group">
                                            <input type="number" id="number_incoming_doc" required="true"
                                                   class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}"
                                                   name="number"
                                                   value="{{ old('number') ?? $outgoingDocument->number ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="input-group-text" @if($method == 'create'))
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Проверить на повторную регистарцию"
                                                         @endif>
                                                    Проверить
                                                </button>
                                            </div>
                                            @include('crm.error_message', ['nameField' => 'number'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>{{ __('validation.attributes.incoming_letter_number') }}</label>
                                        <input type="number"
                                               class="form-control {{ $errors->has('incoming_letter_number') ? 'is-invalid' : '' }}"
                                               name="incoming_letter_number"
                                               value="{{ old('incoming_letter_number') ?? $outgoingDocument->incoming_letter_number ?? '' }}">
                                        @include('crm.error_message', ['nameField' => 'incoming_letter_number'])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.date_letter_at') }}</label>
                                <input type=""
                                       class="form-control date-picker {{ $errors->has('date_letter_at') ? 'is-invalid' : '' }}"
                                       name="date_letter_at"
                                       autocomplete="off"
                                       value="{{ old('date_letter_at') ?? $outgoingDocument->date ?? '' }}">
                                @include('crm.error_message', ['nameField' => 'date_letter_at'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('validation.attributes.from') }}</label>
                                <select
                                    class="form-control select2 {{ $errors->has('from_user_id') ? 'is-invalid' : '' }}"
                                    name="from_user_id" required="required">
                                    @forelse($structuralUnits as $structuralUnit)
                                        @if(!empty($structuralUnit['roles']))
                                            <optgroup label="{{ $structuralUnit['name'] }}">
                                                @foreach($structuralUnit['roles'] as $role)
                                                    @if($role->users->isNotEmpty())
                                                        <optgroup
                                                            label="&nbsp;&nbsp;&nbsp;&nbsp;{{ $role->display_name }}">
                                                            @foreach($role->users as $user)
                                                                <option value="{{ $user->id }}"
                                                                        @if((@old('from_user_id') ?? $outgoingDocument->from_user_id ?? 0) == $user->id) selected @endif
                                                                >&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->fullName }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @empty
                                        <p>Нет пользователей</p>
                                    @endforelse
                                </select>
                                @include('crm.error_message', ['nameField' => 'from_user_id'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('validation.attributes.note') }}</label>
                        <textarea name="note" class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}"
                                  rows="4">{{ old('note') ?? $outgoingDocument->note ?? '' }}</textarea>
                        @include('crm.error_message', ['nameField' => 'note'])
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-3">
        <div class="card card-primary">
            <div class="card-body row">
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>

