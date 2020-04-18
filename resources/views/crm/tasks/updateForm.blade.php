<div id="ModalBoxEdit" class="modal fade">
    <div class="modal-dialog">
        <form id="contractor_form" role="form" method="POST" onsubmit="validationHelper.calendarUpdate(event, $(this),calendar);" >
            {{--action="{{route('project.contractor')}}"--}}
            {{ csrf_field() }}
            {{ method_field($form_method) }}
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h4 class="modal-title">Ректирование события</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
{{--                    <!-- Основное содержимое модального окна -->--}}
                    <div class="modal-body">
                        <input type="hidden" name="id" class="form-control" id="example-input-id-edit"  value="">
                        <div class="form-group">
                            <label for="example-input-title-edit">Название задачи</label>
                            <input type="text" autocomplete="off" name="title" class="form-control" id="example-input-title-edit" placeholder="Введите название задачи" value="">
                        </div>
                        <div class="form-group">
                            <label for="example-input-title-edit">Выберите материал</label>
                            <select class="js-example-material-edit js-states form-control" name="material_id" style="width:100%;">
                                <option></option>
                                @foreach($materials as $material)
                                    <option value="{{$material->id}}">{{$material->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-15 input-append form_datetime form-group">
                            <label for="input-date-start-task-edit">Дата начала события</label>
                            <div class="input-group dateTime" id="datetimepicker-start-task-edit" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#datetimepicker-start-task-edit" >
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input name="start" type="text" placeholder="Введите дату начала" autocomplete="off" id="input-date-start-task-edit" class="form-control datetimepicker-input" data-target="#datetimepicker-start-task-edit" data-toggle="datetimepicker"/>
                            </div>
                        </div>
                        <div class="mb-15 input-append form_datetime form-group">
                            <label for="input-date-end-task-edit">Дата окончания события</label>
                            <div class="input-group dateTime" id="datetimepicker-end-task-edit" data-target-input="nearest">
                                <div class="input-group-prepend" data-target="#datetimepicker-end-task-edit">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input name="end" type="text" placeholder="Введите дату начала" id="input-date-end-task-edit" autocomplete="off" class="form-control datetimepicker-input" data-target="#datetimepicker-end-task-edit" data-toggle="datetimepicker"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-input-title-edit">Выберите ответственного</label>
                            <select class="js-example-responsible-edit js-states form-control" name="user_id" style="width:100%;">
                                <option></option>
                                @foreach($responsibles as $responsible)
                                    <option value="{{$responsible->id}}">{{$responsible->getFIO()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="js-example-description-edit">Текст задачи</label>
                            <textarea id="js-example-description-edit" name="description" placeholder="Описание задачи" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>
</div>
