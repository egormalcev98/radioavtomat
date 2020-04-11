<div class="row" id="dt_filters">
    <div class="col-3">
        <div class="form-group">
            <label>{{ __('outgoing_documents.filters.period') }}</label>
            <input onchange="Main.updateDataTable(event);" class="form-control date-range-picker" name="period">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label>{{ __('outgoing_documents.list_columns.document_type') }}</label>
            <select onchange="Main.updateDataTable(event);" class="form-control select2" name="document_type">
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
            <label>{{ __('outgoing_documents.list_columns.outgoing_doc_status') }}</label>
            <select onchange="Main.updateDataTable(event);" class="form-control select2" name="outgoing_doc_status">
                <option value="">Ничего не выбрано</option>
                @if($outgoingDocStatuses->isNotEmpty())
                    @foreach($outgoingDocStatuses as $outgoingDocStatus)
                        <option value="{{ $outgoingDocStatus->id }}">{!! $outgoingDocStatus->name !!}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
