@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
@stop

@section('content')
    <section class="content">
        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header calendar-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    @if(isset($routeCreateTask))
                                        <button id="btn-task-create" class="btn btn-success"
                                                onclick="Task.createTask('{{$routeCreateTask}}')">
                                            <i class="fas fa-plus"></i> Добавить задачу
                                        </button>
                                    @endif
                                    @if(isset($routeCreateOrder))
                                        &nbsp;&nbsp;
                                        <button id="btn-task-create" class="btn btn-success"
                                                onclick="Task.createTask('{{$routeCreateOrder}}')">
                                            <i class="fas fa-plus"></i> Добавить приказ
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex float-right">
                                    <div class="pr-2">
                                        <select class="refetch_events form-control select2 task_users_select"
                                                id="responsible_users" multiple="multiple"
                                                data-placeholder="Сотрудники">
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->fullName}}
                                                    - {{$user->work_phone_number}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <button type="button" id="calendar-show-filter" class="btn btn-primary">Фильтры
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="task_hidden" id="task-filter">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary w-100" id="task_years_show">Год</button>
                                        <div class="task_years task_hidden" id="task_years">
                                            <div class="row mb-1">
                                                @for ($i = 0; $i < 3; $i++)
                                                    <div class="col-4 pr-1 pl-1">
                                                        <button class="btn btn-default w-100 task_data_goto"
                                                                data-goto="{{$years[$i]}}">
                                                            {{$years[$i]}}
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                            <div class="row">
                                                @for ($i = 3; $i < 6; $i++)
                                                    <div class="col-4 pr-1 pl-1">
                                                        <button class="btn btn-default w-100 task_data_goto"
                                                                data-goto="{{$years[$i]}}">
                                                            {{$years[$i]}}
                                                        </button>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="form-control w-100 refetch_events" id="task_status">
                                            <option value="">Все статусы</option>
                                            @foreach($taskStatuses as $status)
                                                <option value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                @foreach($months as $month)
                                    <div class="col-2">
                                        <button class="btn btn-default w-100 task_data_goto"
                                                data-goto="{{$month['year']}}-{{$month['number']}}">
                                            {{$month['month']}} {{$month['year']}}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                            </div>
                            <div class="col-4 text-center">
                                <h2 id="title"></h2>
                            </div>
                            <div class="col-4">
                                {{--                                <a href="#" id="status-info">--}}
                                {{--                                    <i class="fas fa-info-circle float-right" style="font-size: 30px;"></i>--}}
                                {{--                                </a>--}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-7">
                                <button type="button" class="btn btn-primary task_primary" data-grid="dayGridMonth">
                                    Месяц
                                </button>
                                <button type="button" class="btn btn-primary task_primary" data-grid="timeGridWeek">
                                    Неделя
                                </button>
                                <button type="button" class="btn btn-primary task_primary" data-grid="timeGridDay">День
                                    табл.
                                </button>
                                <button type="button" class="btn btn-primary task_primary" data-grid="dayGridDay">День
                                </button>
                            </div>
                            <div class="col-5">
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary" id="calendar-custom-prev"><i
                                            class="fas fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-primary" onclick="Task.selectDate()">Выбрать
                                    </button>
                                    <button type="button" class="btn btn-primary" id="calendar-custom-today">Cегодня
                                    </button>
                                    <button type="button" class="btn btn-primary" id="calendar-custom-next"><i
                                            class="fas fa-chevron-right"></i></button>
                                    <div class="task_absolute" id="task_absolute_month">
                                        @foreach($allMonths as $month)
                                            <button class="btn btn-default w-100 task_data_goto"
                                                    data-goto="{{$month['year']}}-{{$month['number']}}">
                                                {{$month['month']}} {{$month['year']}}
                                            </button>
                                        @endforeach
                                    </div>
                                    <div class="task_absolute" id="task_absolute_day">
                                    </div>
                                    <div class="task_absolute" id="task_absolute_weeks">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--модалька НЕ УДАЛЯТЬ-->
            <div id="task_show_modal" class="modal fade">
                <div class="modal-dialog">
                    <div id="task_show_modal_content" class="modal-content">
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop
@section('js')
    <script>
        var getTasksUrl = {!! json_encode($getTasksUrl) !!};
        var getTaskWeeks = {!! json_encode(route('tasks.get_weeks')) !!};
        var errorMessage  = `@include('crm.tasks.error_modal')`;
    </script>
    <script src="{{ asset('/js/task.js') }}"></script>
@stop
