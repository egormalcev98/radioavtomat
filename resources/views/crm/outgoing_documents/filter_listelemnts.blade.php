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
             <i class="fas fa-print" style="font-size: 38px; margin-top: 31px"></i>
        </div>
    </div>
</div>
