<form action="{{ route('outgoing_documents.print') }}">
    <div class="col-12 row" id="dt_filters">
        <div class="col-3">
            <div class="form-group">
                <label>{{ __('outgoing_documents.filters.period') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input onchange="Main.updateDataTable(event);" class="form-control date-range-picker" name="period" autocomplete="off">
                </div>
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
        <div class="col-1">
            <label>&nbsp;</label>
            <button class="btn btn-block btn-secondary"><i class="fas fa-print"></i></button>
        </div>

        <div class="col-2">
            <label>&nbsp;</label>
            <a href="/activity" type="button" class="btn btn-block btn-warning">История</a>
        </div>
    </div>
</form>
