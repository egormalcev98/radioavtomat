<!-- left column -->
<!-- general form elements -->
<div class="col-12 row">
    <div class="col-3">
        <div class="card card-primary">
            <!-- form start -->
            <div class="card-body row">
                <div class="col-12">

                    @if($method != 'create')
                        <div class="form-group">
                            <label>{{ __('notes.form.number') }}</label>
                            <input type="text" disabled
                                   class="form-control"
                                   value="{{$note->number}}">
                        </div>
                    @endif

                    <div class="form-group">
                        <label>{{ __('notes.form.title') }}</label>
                        <input type="text" required="true"
                               class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               name="title"
                               value="{{ old('title') ?? $note->title ?? '' }}">
                        @include('crm.error_message', ['nameField' => 'title'])
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>{{ __('notes.form.category_note_id') }}</label>
                                <select
                                    class="form-control select2 {{ $errors->has('category_note_id') ? 'is-invalid' : '' }}"
                                    name="category_note_id" required="required">
                                    @if($categoryNotes->isNotEmpty())
                                        @foreach($categoryNotes as $categoryNote)
                                            <option value="{{ $categoryNote->id }}"
                                                    @if((@old('category_note_id') ?? $note->category_note_id ?? 0) == $categoryNote->id) selected @endif >{{ $categoryNote->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @include('crm.error_message', ['nameField' => 'category_note_id'])
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('notes.form.pages') }}</label>
                                <input type="number" required="true"
                                       class="form-control {{ $errors->has('pages') ? 'is-invalid' : '' }}"
                                       name="pages"
                                       value="{{ old('pages') ?? $note->pages ?? '' }}">
                                @include('crm.error_message', ['nameField' => 'pages'])
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('notes.form.status_note_id') }}</label>
                        <select
                            class="form-control select2 {{ $errors->has('status_note_id') ? 'is-invalid' : '' }}"
                            name="status_note_id" required="required">
                            @if($statusNotes->isNotEmpty())
                                @foreach($statusNotes as $statusNote)
                                    <option value="{{ $statusNote->id }}"
                                            @if((@old('status_note_id') ?? $note->status_note_id ?? 0) == $statusNote->id) selected @endif >{{ $statusNote->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @include('crm.error_message', ['nameField' => 'status_note_id'])
                    </div>

                    <div class="form-group">
                        <label>{{ __('notes.form.user_id') }}</label>
                        <select
                            class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                            name="user_id" required="required">
                            @forelse($structuralUnits as $structuralUnit)
                                @if(!empty($structuralUnit['roles']))
                                    <optgroup label="{{ $structuralUnit['name'] }}">
                                        @foreach($structuralUnit['roles'] as $role)
                                            @if($role->users->isNotEmpty())
                                                <optgroup
                                                    label="&nbsp;&nbsp;&nbsp;&nbsp;{{ $role->display_name }}">
                                                    @foreach($role->users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if((@old('user_id') ?? $note->user_id ?? 0) == $user->id) selected @endif
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
                        @include('crm.error_message', ['nameField' => 'user_id'])
                    </div>

                    <div class="form-group">
                        <label>{{ __('notes.form.created_at') }}</label>
                        <input type="text"
                               class="form-control
                                       @if($method == 'create')
                                   date-picker-time-autocomplete
@else
                                   date-picker-time
@endif
                               {{ $errors->has('created_at') ? 'is-invalid' : '' }}"
                               name="created_at"
                               autocomplete="off"
                               value="{{ old('created_at') ?? $note->created_at ?? '' }}"
                               @if($method != 'create')
                               disabled
                            @endif
                        >
                        @include('crm.error_message', ['nameField' => 'created_at'])
                    </div>

                </div>
            </div>
            @if(($method == 'edit' and $IAmCreator)  or $method == 'create')
                @include('crm.box_footer')
            @endif
        </div>
    </div>


    <div class="col-5">
        <div class="card card-primary">
            <!-- form start -->
            <div class="card-body row">
                <div class="col-12">
                    <div class="form-group">
                        <label>{{ __('notes.form.text') }}</label>
                        <textarea name="text" class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}"
                                  rows="21">{{ old('text') ?? $note->text ?? '' }}</textarea>
                        @include('crm.error_message', ['nameField' => 'text'])
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-4">
        @if($method == 'show' and $IAmCreator)
            @permission('update_'.$permissionKey)
            <div class="col-12 row mb-3">
                <a href="{{ route('notes.edit', $note->id) }}"
                   class="btn btn-block btn-success" style="pointer-events:all;">Редактировать</a>
            </div>
            @endpermission
        @endif
        <div class="card">
            @if($method != 'show')
                <div class="card-header">
                    <button type="button" class="btn btn-info" onclick="Note.addTrScan($(this));">Добавить
                        скан (pdf,doc,docx,xlsx,bmp,jpeg)
                    </button>
                </div>
            @endif
            <div class="card-body row">
                <table class="table table-bordered table-sm">
                    @include('crm.notes.file_table_head')
                    <tbody>
                    <tr style="display: none;" id="clone_file_tr">
                        @include('crm.notes.file_template')
                    </tr>
                    @if(isset($noteFiles) and $noteFiles->isNotEmpty())
                        @foreach($noteFiles as $noteFile)
                            <tr>@include('crm.notes.file_template', ['dataFile' => $noteFile])</tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>

