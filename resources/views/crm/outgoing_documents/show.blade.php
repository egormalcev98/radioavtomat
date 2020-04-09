@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @permission('read_'.$permissionKey)
        <a class="btn btn-outline-primary float-right" href="{{ $action }}">{{ __('references.main.edit_button') }}</a>
    @endpermission
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-12">
            <!-- general form elements -->
                <fieldset disabled="true">
                    @include('crm.outgoing_documents.form_elements')
                </fieldset>
            <!-- /.card -->
        </div>
    </div>
@stop


@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').attr('disabled', true);
        });
    </script>
@stop
