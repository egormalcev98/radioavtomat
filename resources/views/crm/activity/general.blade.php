@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop
<link rel="stylesheet" href="{{ asset('css/activity.css') }}">
@section('content')
    <div class="card">
        <div class="card-body">
             @include('crm.activity.filters')
            <div id="activity_listelements">
                @include('crm.activity.listelements')
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('/js/activity.js') }}"></script>
@stop
