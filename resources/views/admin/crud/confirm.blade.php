@extends('layouts.admin')

@section('title', ($title ?? '') . ' | 管理画面')

@section('content_header_label')
    <div class="col-12">
        <h1>{{ $title ?? '' }}</h1>
    </div>
    @include('admin.block.breadcrumb')
@stop

@section('content')
    @yield('content_top')

    <div class="card">
        <div class="card-header">
            <div class="col-6 float-left">
                <h4 style=" padding: 0.375rem 0;" class="m-0">{{ $titlePage }}</h4>
            </div>
        </div>
        {!! Form::open(['route' => [$routeList['complete'],  isset($item) ? $item->getKey() : null], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="card-body">
            <div class="admin-crud-form" id="admin-crud-form-confirm">
                @include ('admin.crud.parts.form_confirm')
            </div>
            <div class="row text-center mt-2">
                <div class="col-sm-12">
                    {!! Form::submit('戻る', ['name' => 'form_back','id' => 'admin-crud-form-btn-back', 'class' => 'btn btn-default btn-md p-3 mr-3']) !!}
                    {!! Form::submit(isset($item) ? '更新' : '保存', ['name' => 'submit', 'id '=> 'admin-crud-form-btn-complete', 'class' => 'btn btn-primary btn-md p-3']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    @yield('content_bottom')
@stop

@section('js')
    @parent
    @include('admin.crud.parts.form_js')
    @yield('script_detail')
@stop
