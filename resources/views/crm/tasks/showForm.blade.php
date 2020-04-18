<div id="ModalBoxShow" class="modal fade">
    <div class="modal-dialog">
        <form id="contractor_form_show" role="form" method="POST">
{{--            action="{{route('project.contractor')}}"--}}
            {{ csrf_field() }}
            {{ method_field($form_method) }}
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h4 class="modal-title">Просмотр задачи</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="example-input-title-show">Название задачи</label>
                        <input type="text" autocomplete="off" name="title" class="form-control" id="example-input-title-show" placeholder="Введите название задачи" value="">
                    </div>
                    <div class="form-group">
                        <label for="example-input-title-show">Выберите материал</label>
                        <select class="js-example-material-show js-states form-control" name="material_id" style="width:100%;">
                            <option></option>
                            @foreach($materials as $material)
                                <option value="{{$material->id}}">{{$material->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-15 input-append form_datetime form-group">
                        <label for="input-date-start-task-show">Дата начала события</label>
                        <div class="input-group dateTime" id="datetimepicker-start-task-show" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#datetimepicker-start-task-show" >
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input name="start" type="text" placeholder="Введите дату начала" autocomplete="off" id="input-date-start-task-show" class="form-control datetimepicker-input" data-target="#datetimepicker-start-task-show" data-toggle="datetimepicker"/>
                        </div>
                    </div>
                    <div class="mb-15 input-append form_datetime form-group">
                        <label for="input-date-end-task-show">Дата окончания события</label>
                        <div class="input-group dateTime" id="datetimepicker-end-task-show" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#datetimepicker-end-task-show">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input name="end" type="text" placeholder="Введите дату начала" id="input-date-end-task-show" autocomplete="off" class="form-control datetimepicker-input" data-target="#datetimepicker-end-task-show" data-toggle="datetimepicker"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-input-title-create">Выберите ответственного</label>
                        <select class="js-example-responsible-show js-states form-control" name="user_id" style="width:100%;">
                            <option></option>
                            @foreach($responsibles as $responsible)
                                <option value="{{$responsible->id}}">{{$responsible->getFIO()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="js-example-description-show">Текст задачи</label>
                        <textarea id="js-example-description-show" name="description" placeholder="Описание задачи" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="editButton" class="btn btn-primary">Редактировать</button>
                    <button type="button" id="deleteButton" class="btn btn-danger">Удалить</button>
                </div>
            </div>
        </form>
    </div>
</div>
