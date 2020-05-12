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

    @include('crm.box_errors')
        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if($todayJobs->isNotEmpty())
                                <table class="table table-bordered">
                                    <tr>
                                        <th>№</th>
                                        <th>Описание</th>
                                        <th>Создано</th>
                                    </tr>
                                @foreach($todayJobs as $todayJob)
                                        <tr @if($todayJob->red == 1)
                                                style="background: lightpink"
                                            @endif>
                                            <td>{{++$loop->index}}</td>
                                            <td>{!! $todayJob->href !!}</td>
                                            <td>{!! $todayJob->created_at !!}</td>
                                        </tr>
                                @endforeach
                                </table>
                            @else
                                Задач на сегодня нет.
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
