<!-- Заголовок модального окна -->
<form role="form" method="POST" enctype="multipart/form-data" id="task_form_data">
    @csrf
{{--    @isset($task)--}}
{{--        {{ method_field('PATCH') }}--}}
{{--    @endisset--}}
    <div class="modal-header">
        <h4 class="modal-title" id="m_title">{{$title}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <!-- Основное содержимое модального окна -->
    <div class="modal-body">

        <div class="form-group">
            <label>Дата и время начала</label>
            <input
                type="text" autocomplete="off" required="required" class="form-control date-picker-time" name="date_start"
                @isset($task)
                value="{{\Illuminate\Support\Carbon::parse($task->start)->format('d.m.Y H:i')}}"
                @endisset
            >
        </div>

        <div class="form-group">
            <label>Дата и время завершения</label>
            <input type="text" autocomplete="off" required="required"  class="form-control date-picker-time" name="date_end"
                   @isset($task)
                   value="{{\Illuminate\Support\Carbon::parse($task->end)->format('d.m.Y H:i')}}"
                @endisset
            >
        </div>

        @if($type == 'task')
            <div class="form-group">
                <label>Тип события</label>
                <select
                    class="form-control"
                    name="event_type_id" required="required">
                    @if($eventTypes->isNotEmpty())
                        @foreach($eventTypes as $eventType)
                            <option
                                value="{{ $eventType->id }}"
                                @isset($task)
                                @if($task->event_type_id == $eventType->id)
                                selected
                                @endif
                                @endisset
                            >{{ $eventType->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label>Документ №</label>
                <select
                    class="form-control select2-ajax-data"
                    name="incoming_document_id" id="incoming_document_id"
                    data-placeholder="Введите номер документа"
                    data-action="{{ route('incoming_documents.get_documents')}}"
                >
                </select>
            </div>
        @endif

        @isset($task)
            <div class="form-group">
                <label>Статус</label>
                <select
                    class="form-control"
                    name="task_status_id" required="required">
                    @if($taskStatuses->isNotEmpty())
                        @foreach($taskStatuses as $taskStatus)
                            <option
                                value="{{ $taskStatus->id }}"
                                @if($task->task_status_id == $taskStatus->id)
                                selected
                                @endif
                            >{{ $taskStatus->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endisset

        <div class="form-group">
            <label>Ответственный</label>
            <select
                @isset($task)
                @if($task->structural_unit_id or $task->select_all)
                disabled
                @endif
                @endisset
                @if($type == 'order') multiple @endif
                required="required"
                class="form-control select2"
                name="user_ids[]" id="user_ids">
                @if($users->isNotEmpty())
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                                @isset($task)
                                @if(!$task->structural_unit_id and !$task->select_all and in_array($user->id, $task->users()->get()->pluck('id')->toArray()))
                                selected
                            @endif
                            @endisset
                        >{{ $user->fullName }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        @if($type == 'order')
            <div class="form-group disabled">
                <label>По подразделению</label>
                <select
                    @isset($task)
                    @if($task->select_all)
                    disabled
                    @endif
                    @endisset
                    onchange="Task.checkSelectUnit()"
                    class="form-control select2"
                    name="structural_unit_id" id="structural_unit_id">
                    <option value="">Ничего не выбрано</option>
                    @if($structuralUnits->isNotEmpty())
                        @foreach($structuralUnits as $structuralUnit)
                            <option value="{{ $structuralUnit->id }}"
                                    @isset($task)
                                    @if($task->structural_unit_id == $structuralUnit->id )
                                    selected
                                @endif
                                @endisset
                            >{{ $structuralUnit->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group task_select_all_box">
                <input
                    @isset($task)
                    @if($task->select_all)
                    checked
                    @endif
                    @endisset
                    type="checkbox" class="form-control task_select_all" name="select_all" id="task_select_all"
                    onclick="Task.checkSelectAll()">
                <label class="mb-0 ml-1">Выбрать всех</label>
            </div>
        @endif

        <div class="form-group">
            <label>Описание</label>
            <textarea placeholder="Описание задачи"
                      name="text"
                      class="form-control" rows="3">@isset($task){{$task->text}}@endisset</textarea>
        </div>

        <div class="form-group">
            <label>Напомнить за</label>
            <input type="text" name="remember_time" class="form-control task_remember_time" required="required"
                   @isset($task)
                   value="{{$task->remember_time}}"
                   @else
                   value="30"
                @endisset
            >
            <label>минут</label>
        </div>

        <div class="form-group">
            <label>Файл: </label>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Загрузить">
                <input name="new_scan_file" type="file">
            </a>
        </div>

    </div>
    <!-- Футер модального окна -->
    <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-success" onclick="Task.storeOrUpdate('{{$action}}')">Сохранить</button>
    </div>
</form>


