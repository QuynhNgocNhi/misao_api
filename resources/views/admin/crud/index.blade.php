@extends('layouts.admin')

@section('title', ($title ?? ''))

@section('content_header_label')
    <div class="row">
        <div class="col-6">
            <h1>{{ $title ?? '' }}</h1>

        </div>
        <div class="col-6 justify-content-end">
            @include('admin.block.breadcrumb')
        </div>
    </div>
@stop

@section('content')
    @yield('content_top')
    @if (count($searchList) > 0)
        {!! Form::open(['route' => $routeList['index'], 'method' => 'GET', 'id' => 'admin-crud-search-form']) !!}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">検索</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-custom-collapse" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include ('admin.crud.parts.index_search')
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            {!! Form::submit("&nbsp;&nbsp;&nbsp; 検索 &nbsp;&nbsp;&nbsp;", ["class" => "btn btn-primary"]) !!}
                            <button type="reset" class="btn btn-default ml-3">リセット</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endif

    <div class="card">
        <div class="card-header">
            <div class="col-6 float-left">
                <h4 style=" padding: 0.375rem 0;" class="m-0">{{ $titlePage }}</h4>
            </div>
            <div class="col-6 float-right text-right">
                @if(($canCreate ?? false) && !empty($routeList['create']))
                    <a class="btn btn-primary"
                       href="{{ route($routeList['create']) }}">
                        追加
                    </a>
                @endif

{{--                @if(($canDeleteAll ?? false) && !empty($routeList['deleteAll']))--}}
{{--                    <a class="btn btn-danger" id="delete-all"--}}
{{--                       href="{{ route($routeList['deleteAll']) }}">--}}
{{--                        delete all--}}
{{--                    </a>--}}
{{--                @endif--}}
                    @yield('button_table')
            </div>
        </div>
        <div class="card-body">
            <div class="admin-index-table" id="admin-index-table">
                @include ('admin.crud.parts.index_table')
            </div>
        </div>
    </div>
    @yield('content_bottom')
@stop

@section('js')
    <script>
    $(document).ready(function () {
        $(".btn-custom-collapse").click(function() {
            if ($(this).children().hasClass("fa-chevron-up")) {
                $(this).children(".fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            } else {
                $(this).children(".fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            }
        });

        $('input').keydown(function (e) {
            if (e.which === 32 &&  e.target.selectionStart === 0) {
                return false;
            }
        });

        @if (session('success'))
            Toast.success('{{ session('success') }}')
        @elseif(session('error'))
            Toast.error('{{ session('error') }}')
        @endif

    });

    </script>
    @parent
    @include('admin.crud.parts.index_js')
    @yield('script_detail')
@stop
