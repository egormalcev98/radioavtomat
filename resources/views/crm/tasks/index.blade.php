@extends('adminlte::page')


@section('content')
    <section class="content">
        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header calendar-header">
                        <div class="row d-flex justify-content-between">
							@if(isset($routeCreate))
								<div class="col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto">
									<div class="form-group">
										<a href="#" id="btn-task-create" class="btn btn-success "><i class="fas fa-plus"></i> Добавить задачу</a>
									</div>
								</div>
							@endif
							<div class="col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto">
								<div class="d-flex justify-content-between flex-wrap">
									<div class="pr-2">
										<select class="js-example-responsible js-states form-control-lg"  style="width:200px; font-size:13px;" name="user">
											  <option></option>
												@foreach($responsibles as $responsible)
													<option value="{{$responsible->id}}">{{$responsible->getFIO()}}</option>
												@endforeach
										</select>
									</div>
									<div>
										<a href="#" id="calendar-show-filter" class="btn btn-primary">Показать фильтры</a>
									</div>
								</div>
							</div>
						</div>
						<div id="tusk-filter">
                            <div class="row">
                                <div class="col-auto col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    {{--										<div class="form-group">--}}
    {{--                                            <label for="example-input-title-create">Выберите дату</label>--}}
    {{--                                            <div class="input-group-prepend">--}}
    {{--                                                <span class="input-group-text" id="basic-addon-data"><i class="fa fa-calendar"></i></span>--}}
    {{--                                            </div>--}}
    {{--                                            <input type="text" class="form-control dateTime" placeholder="Дата" autocomplete="off" name="dateFilter"  style="padding-left: 45px;">--}}
    {{--                                        </div>--}}


                                                <div class="form-group">
                                                    <label for="example-input-title-create">Выберите дату</label>
                                                    <div class="input-group" id="calendar-filer-date" data-target-input="nearest">
                                                        <div class="input-group-prepend" data-target="#calendar-filer-date" >
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                        <input id="input-calendar-filter-date" type="text" placeholder="Дата" autocomplete="off" class="form-control datetimepicker-input" data-target="#calendar-filer-date" data-toggle="datetimepicker"/>
                                                        <div class="input-group-append calendar-filter-date-clear">
                                                            <div class="input-group-text"><i class="fas fa-times-circle"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="example-input-title-create">Материал</label>
                                                <select class="js-example-material-filter js-states form-control" style="width:100%;">
                                                    <option></option>
                                                    @foreach($materials as $material)
                                                        <option value="{{$material->id}}">{{$material->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="example-input-title-create">Статус</label>
                                                <select class="js-example-status-filter js-states form-control" style="width:100%;">
                                                    <option></option>
                                                    @foreach($referenStatuses as $status)
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
							<div class="row justify-content-center position-relative">
                                <div class="col-auto mb-3">
									    <h2 class="center" id="title"></h2>
								</div>

								<div class="col-auto position-absolute" style="bottom:15px; right:15px;">
									    <a href="" id="status-info">
										    <i class="fas fa-info-circle" style="font-size: 30px;"></i>
										</a>
								</div>
								<div id="status-info-block" class="col-auto position-absolute border border-dark p-3" style="top:60px; right:15px; z-index: 9;background: white;">
									<ul class="list-group">
										@foreach($referens as $referen)
											<li class="m-1">
												<div class="color-block color-block-{{$referen->id}}"></div>
												<div>
													<p>{{$referen->name}}</p>
												</div>
											</li>
										@endforeach
                                            <li class="m-1">
                                                <div class="color-block color-block-standart"></div>
                                                <div>
                                                    <p>Стандартная задача</p>
                                                </div>
                                            </li>
											<li class="m-1">
												<div class="color-block color-block-def"></div>
												<div>
													<p>Сегодняшний день</p>
												</div>
											</li>
									</ul>
								</div>
							</div>
							<div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 btn btn-primary st-button" id="month">Месяц</div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 btn btn-primary st-button" id="week">Неделя</div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 btn btn-primary st-button" id="day">День</div>

                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 offset-lg-4 offset-md-4 d-flex justify-content-between">
                                    <div class="btn btn-primary st-button" id="calendar-custom-today">Cегодня</div>

                                    <div class="btn btn-primary st-button" id="calendar-custom-prev"><i class="fas fa-chevron-left"></i></div>

                                    <div class="btn btn-primary st-button" id="calendar-custom-next"><i class="fas fa-chevron-right"></i></div>
                                </div>
							</div>
						<div class="box-body">
							<div id='calendar'></div>
						</div>
                    </div>
                </div>
            </div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="box">

				</div>
			</div>
                    @includeIf('crm.task.updateForm')
                    @includeIf('crm.task.createForm')
                    @includeIf('crm.task.showForm')
        </div>
    </section>
@stop
@section('js')
    <script>
            var calendarEl = document.getElementById('calendar');
            var responsibleUser = $('.js-example-responsible').val();
            var calendar = new FullCalendar.Calendar(calendarEl, {
				customButtons: {
                    myCustomButton: {
                        text: 'Месяц',
                        click: function () {
							calendar.today();
                        }
                    }
                },
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                // defaultView: 'dayGridMonth',
                locale: 'ru',
				header: false,
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                displayEventTime: true,
				aspectRatio: 1.5,
				scrollTime: '00:00',
				defaultView: 'dayGridMonth',
                eventSources: [
                    // your event source
                    {
                        url: '/get-task', // use the `url` property
                        color: 'yellow',    // an option!
                        textColor: 'black',  // an option!
                        extraParams: function(){
                            return{
                                user: $('.js-example-responsible').val(),
                                material: $('.js-example-material-filter').val(),
                                status: $('.js-example-status-filter').val(),
                            };
                        }

                    }
                ],
				eventClick: function (info) {
                    $("#example-input-title-show").val(info.event.extendedProps.title);
                    $('.js-example-material-show').select2({
                        placeholder: "Выберите материал",
                        allowClear: true
                    });
                    $("#example-input-id-edit").val(info.event.id);
                    $(".js-example-material-show").val(info.event.extendedProps.material).trigger('change');
                    $('.js-example-responsible-show').select2({
                        placeholder: "Выберите отвественного",
                        allowClear: true
                    });
                    $(".js-example-responsible-show").val(info.event.extendedProps.userId).trigger('change');
                    $("#input-date-start-task-show").val(info.event.extendedProps.start);
                    $("#input-date-end-task-show").val(info.event.extendedProps.end);
                    $("#js-example-description-show").text(info.event.extendedProps.description);
                    $("#ModalBoxShow").modal('show');

                    $("#example-input-title-edit").val(info.event.extendedProps.title);
                    $('.js-example-material-edit').select2({
                        placeholder: "Выберите материал",
                        allowClear: true
                    });
                    $(".js-example-material-edit").val(info.event.extendedProps.material).trigger('change');
                    $('.js-example-responsible-edit').select2({
                        placeholder: "Выберите отвественного",
                        allowClear: true
                    });
                    $(".js-example-responsible-edit").val(info.event.extendedProps.userId).trigger('change');
                    $("#input-date-start-task-edit").val(info.event.extendedProps.start);
                    $("#input-date-end-task-edit").val(info.event.extendedProps.end);
                    $("#js-example-description-edit").text(info.event.extendedProps.description);


                    $('#ModalBoxShow #deleteButton').click(function(){
                        $('#ModalBoxShow').modal('hide');
                        Model.delete_event('{{route($add_element_route . '.index')}}/' + info.event.extendedProps.id,'{{csrf_token()}}');
                    });
                    $('#ModalBoxShow #editButton').click(function(){
                        $('#ModalBoxShow').modal('hide');
                        EventForm.editForm('{{route($add_element_route . '.index')}}/' + info.event.extendedProps.id);
                    });
				},
				viewSkeletonRender: function( view, element ) {
				  let date
				  switch (view.type) {
					case 'timeGridDay':
					  date = view.start.format('DD dddd YYYY')
					  break
					case 'timeGridWeek':
					  date = view.start.format('MMMM')
					  break
					case 'dayGridMonth':
					  date = view.start.format('MMMM')
					  break
				  }
				  $('#title').text(view.view.title);
				},
                datesRender: function( view, el ) {
                    let date
                    switch (view.type) {
                        case 'timeGridDay':
                            date = view.start.format('DD dddd YYYY')
                            break
                        case 'timeGridWeek':
                            date = view.start.format('MMMM')
                            break
                        case 'dayGridMonth':
                            date = view.start.format('MMMM')
                            break
                    }
                    $('#title').text(view.view.title);
                },
            });
            calendar.render();

			$("#day").on('click', function() {
				calendar.changeView('timeGridDay');
			});

			$("#week").on('click', function() {
				calendar.changeView('timeGridWeek');
			});

			$("#month").on('click', function() {
				calendar.changeView('dayGridMonth');
			});

            $("#calendar-custom-prev").on('click', function() {
                calendar.prev();
            });

            $("#calendar-custom-next").on('click', function() {
                calendar.next();
            });

            $("#calendar-custom-today").on('click', function() {
                calendar.today();
            });

			$('#status-info').on('click',function(){
				event.preventDefault();
				$('#status-info-block').toggleClass("active");
			});

			$(document).ready(function() {
				$('.js-example-responsible').select2({
					placeholder: "Выберите отвественного",
					allowClear: true
				});
			});
			$('.js-example-material-filter').select2({
				placeholder: "Выберите материал",
				allowClear: true
			});
			$('.js-example-status-filter').select2({
				placeholder: "Выберите статус",
				allowClear: true
			});
			$('#btn-task-create').on('click',function(){
				event.preventDefault();
				$('#ModalBoxCreate #contractor_form').attr('action', '{{route($add_element_route . '.store')}}');
				$("#ModalBoxCreate").modal('show');
				$('.js-example-responsible-create').select2({
					placeholder: "Выберите отвественного",
					allowClear: true
				});
				$('.js-example-material-create').select2({
					placeholder: "Выберите материал",
					allowClear: true
				})
			});
            $('#datetimepicker-start-task').datetimepicker({
                format: 'DD.MM.YYYY HH:mm',
                locale: 'ru',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
                }
            );
            $('#datetimepicker-end-task').datetimepicker({
                useCurrent: false,
                format: 'DD.MM.YYYY HH:mm',
                locale: 'ru',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });

            $("#datetimepicker-start-task").on("change.datetimepicker", function (e) {
                $('#datetimepicker-end-task').datetimepicker('minDate', e.date);
            });

            $("#datetimepicker-end-task").on("change.datetimepicker", function (e) {
                $('#datetimepicker-start-task').datetimepicker('maxDate', e.date);
            });

            $('.js-example-responsible').on('change', function (e) {
                calendar.refetchEvents();
            });
            $('#input-calendar-filter-date').on('focusout', function () {
                var isoDat =  moment($('#input-calendar-filter-date').val(),'DD.MM.YYYY HH:mm').format('YYYY-MM-DD HH:mm');
                calendar.gotoDate(isoDat);
            });
            $('.js-example-material-filter').on('change', function (e) {
                calendar.refetchEvents();
            });
            $('.js-example-status-filter').on('change', function (e) {
                calendar.refetchEvents();
            });

            var EventForm = {
                editForm:function(name_controller){
                    $('#ModalBoxEdit #contractor_form').attr('action', name_controller);
                    $('#ModalBoxEdit input[name=_method]').attr('value', 'PUT');
                    $("#ModalBoxEdit").modal('show');
                }
            }

            $('#calendar-filer-date').datetimepicker({
                format: 'DD.MM.YYYY HH:mm',
                locale: 'ru',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                closeText: 'Clear', // Text to show for "close" button
            });

            $('.calendar-filter-date-clear').on('click', function(){
                $('#input-calendar-filter-date').val('');
            });

            $('#calendar-show-filter').on('click',function(){
                event.preventDefault();
                $('#tusk-filter').toggleClass("active");
            });

    </script>
@stop
