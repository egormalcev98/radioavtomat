<!-- Заголовок модального окна -->
<div class="modal-header">
    <h4 class="modal-title" id="m_title">{{$title}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<!-- Основное содержимое модального окна -->
<div class="modal-body">
    @if($time)
        <div class="form-group">
            <label>Дата и время</label>
            <input type="text" autocomplete="off" class="form-control" disabled
                   value="{{$time}}">
        </div>
    @endif
    @if($event)
        <div class="form-group">
            <label>Тип события</label>
            <input type="text" autocomplete="off" class="form-control" disabled
                   value="{{$event}}">
        </div>
    @endif
    @if($status)
        <div class="form-group">
            <label>Статус</label>
            <input type="text" autocomplete="off" class="form-control" disabled
                   value="{{$status}}">
        </div>
    @endif
    @if($text)
        <div class="form-group">
            <label>Описание</label>
            <textarea disabled placeholder="Описание задачи"
                      class="form-control" rows="3">{{$text}}</textarea>
        </div>
    @endif
    @if($incomingDocument)
        <div class="form-group">
            <label>Документ №</label>
            <input type="text" autocomplete="off" class="form-control" disabled
                   value="{{$incomingDocument}}">
        </div>
    @endif
    @if($file['name'])
        <div class="form-group">
            <label>Файл: </label>
            <a href="{{ Storage::url($file['path']) }}" target="_blank">{{$file['name']}}</a>
        </div>
    @endif
    @if($user)
        <div class="form-group">
            <label>Ответственный</label>
            <input type="text" autocomplete="off" class="form-control" disabled
                   value="{{$user}}">
            @if($usersCount)
                <label> + ещё {{$usersCount}}</label>
            @endif
        </div>
    @endif
</div>
<!-- Футер модального окна -->
@if($IAmCreator)
    <div class="modal-footer">
        @if($editUrl)
            <button type="button" onclick="Task.editTask('{{$editUrl}}')" class="btn btn-primary">Редактировать</button>
        @endif
        @if($deleteUrl)
            <button type="button" onclick="Task.deleteTask('{{$deleteUrl}}')" class="btn btn-danger">Удалить</button>
        @endif
    </div>
@endif


