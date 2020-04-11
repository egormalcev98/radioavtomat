@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{--        @include('crm.outgoing_documents.filter_listelemnts')--}}

            <div class="p-0">
                {!! $datatable->table() !!}
            </div>
        </div>
    </div>
@stop

@section('js')
	{!! $datatable->scripts() !!}
@stop
