@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    @include('crm.box_errors')

    <div class="row">
        <form role="form" method="POST" action="{{ $action }}" enctype="multipart/form-data" >
        @csrf
        @if($method == 'edit')
            {{ method_field('PATCH') }}
        @endif

        <!-- general form elements -->
            <div class="col-12 row">
                <div class="col-8">
                    <div class="card card-primary">
                        <!-- form start -->

                        @include('crm.incoming_documents.form_elements')

                        @include('crm.box_footer')

                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-info" onclick="IncomingDocument.addTrScan($(this));" >Добавить скан (pdf,doc,docx,xlsx,bmp,jpeg)</button>
                        </div>
                        <div class="card-body row">
                            <table class="table table-bordered table-sm">
                                @include('crm.incoming_documents.file_table_head')
                                <tbody>
                                <tr style="display: none;" id="clone_file_tr">
                                    @include('crm.incoming_documents.file_template')
                                </tr>
                                @if(isset($incomingDocumentFiles) and $incomingDocumentFiles->isNotEmpty())
                                    @foreach($incomingDocumentFiles as $incomingDocumentFile)
                                        <tr>@include('crm.incoming_documents.file_template', ['dataFile' => $incomingDocumentFile])</tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </form>
    </div>
@stop

@if($method == 'edit')
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
    <button type="button" class="btn btn-primary" data-file-id="" onclick="IncomingDocument.saveFileNameModal($(this));" >{{ __('references.main.save_button') }}</button>
</div>
@stop
@endif

@section('js')
    <script src="{{ asset('/js/incoming_document.js') }}"></script>
@stop
