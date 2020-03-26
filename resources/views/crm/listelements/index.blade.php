@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
	@include('crm.references.structure')
@stop

@section('js')
	{!! $datatable->scripts() !!}
@stop