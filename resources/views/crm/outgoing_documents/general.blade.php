@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @yield('content_content')
        </div>
    </div>
@stop

