@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
	@include('crm.listelements.structure'/*, ['filterTemplate']*/)
@stop

@section('js')
	{!! $datatable->scripts() !!}
@stop