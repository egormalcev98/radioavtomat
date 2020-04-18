@extends('adminlte::page')

@include('crm.header')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-auto col-sm-auto col-md-auto col-lg-6 col-xl-6">
                <form method="POST" id="form" action="{{$route}}" enctype="multipart/form-data">
                    @if($method == 'edit')
                        {{ method_field('PATCH') }}
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            @if($controller === 'inquiry.')
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="file" value="1" id="customSwitch1"
                                               @if(isset($model) &&  $model->file) checked @endif>
                                        <label class="custom-control-label" for="customSwitch1">Изображение</label>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group" >
                                <label for="name">{{__('validation.attributes.name')}}</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="{{__('validation.attributes.name')}}" autocomplete="off"
                                       value="{{isset($model) ? $model->name : old("name") }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            @include('crm.saveButton')
                            @include('crm.backButton')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

