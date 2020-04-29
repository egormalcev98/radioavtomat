    <div class="col-12 row" id="dt_filters">
        <div class="col-3">
            <div class="form-group">
                <label>{{ __('notes.filters.period') }}</label>
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
                <label>{{ __('notes.list_columns.category_note') }}</label>
                <select onchange="Main.updateDataTable(event);" class="form-control select2" name="category_note_id">
                    <option value="">Ничего не выбрано</option>
                    @if($categoryNotes->isNotEmpty())
                        @foreach($categoryNotes as $categoryNote)
                            <option value="{{ $categoryNote->id }}">{!! $categoryNote->name !!}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>{{ __('notes.list_columns.status_note') }}</label>
                <select onchange="Main.updateDataTable(event);" class="form-control select2" name="status_note_id">
                    <option value="">Ничего не выбрано</option>
                    @if($statusNotes->isNotEmpty())
                        @foreach($statusNotes as $statusNote)
                            <option value="{{ $statusNote->id }}">{!! $statusNote->name !!}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
