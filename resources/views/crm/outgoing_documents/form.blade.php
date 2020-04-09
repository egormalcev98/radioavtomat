@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    @include('crm.box_errors')

    <div class="row">
        <!-- left column -->
        <div class="col-12">
            <!-- general form elements -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @csrf
                @if($method == 'edit')
                    {{ method_field('PATCH') }}
                @endif

                @include('crm.outgoing_documents.form_elements')

            </form>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('modal')
@section('modal_title', 'Файл')
@section('modal_id', 'modal_file')
<div class="modal-body">
    <div class="form-group">
        <label>Название</label>
        <input type="text" class="form-control" id="new_file_name">
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('references.main.close_button') }}</button>
    <button type="button" class="btn btn-primary" data-file-id=""
            onclick="OutgoingDocument.saveFileNameModal($(this));">{{ __('references.main.save_button') }}</button>
</div>
@stop

@section('js')
    <script src="{{ asset('/js/outgoing_document.js') }}"></script>
@stop

