<div id="ModalBoxCreate" class="modal fade">
    <div class="modal-dialog">
        <form id="contractor_form" role="form" method="POST" onsubmit="validationHelper.create_event(event, $(this));" >
            {{--action="{{route('project.contractor')}}"--}}
            {{ csrf_field() }}
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h4 class="modal-title">Добавить задачу</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="example-input-title-create">Название задачи</label>
                        <input type="text" autocomplete="off" name="title" class="form-control" id="example-input-title-create" placeholder="Введите название задачи" value="">
                    </div>
                    <div class="form-group">
                        <label for="example-input-title-create">Выберите материал</label>
						<select class="js-example-material-create js-states form-control" name="material_id" style="width:100%;">
							  <option></option>
								@foreach($materials as $material)
									<option value="{{$material->id}}">{{$material->code}}</option>
								@endforeach
						</select>
                    </div>
                    <div class="mb-15 input-append form_datetime form-group">
                        <label for="example-input-title-create">Дата начала события</label>
                        <div class="input-group" id="datetimepicker-start-task" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#datetimepicker-start-task" >
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input name="start" type="text" placeholder="Введите дату начала" autocomplete="off" id="input-date-start-task" class="form-control datetimepicker-input" data-target="#datetimepicker-start-task" data-toggle="datetimepicker"/>
                        </div>
                    </div>
                    <div class="mb-15 input-append form_datetime form-group">
                        <label for="daterange">Дата окончания события</label>
                        <div class="input-group" id="datetimepicker-end-task" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#datetimepicker-end-task">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input name="end" type="text" placeholder="Введите дату начала" id="input-date-end-task" autocomplete="off" class="form-control datetimepicker-input" data-target="#datetimepicker-end-task" data-toggle="datetimepicker"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-input-title-create">Выберите ответственного</label>
						<select class="js-example-responsible-create js-states form-control" name="user_id" style="width:100%;">
							  <option></option>
								@foreach($responsibles as $responsible)
									<option value="{{$responsible->id}}">{{$responsible->getFIO()}}</option>
								@endforeach
						</select>
                    </div>
                    <div class="form-group">
                        <label for="example-input-description-create">Текст задачи</label>
						<textarea id="example-input-description-create" name="description" placeholder="Описание задачи" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
