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
    <div class="card">
        <div class="card-header">
            <div class="col-6 float-left">
                <h4 style=" padding: 0.375rem 0;" class="m-0">{{ $titlePage }}</h4>
            </div>
            <div class="col-6 float-right text-right">
                {{-- list --}}
                <a class="btn btn-primary mr-2" href="{{ route($routeList['index']) }}">
                    一覧
                </a>
                {{-- edit --}}
                @if(($canEdit ?? false) && !empty($routeList['edit']))
                    <a class="btn btn-primary mr-2"
                       href="{{ route($routeList['edit'], $item->getKey()) }}">
                        編集
                    </a>
                @endif
                @if(($canDelete ?? false) && (!empty($routeList['destroy']) || !empty($routeList['delete'])))
                    @php($url = route($routeList['destroy'] ?? $routeList['delete'], $item->getKey()))
                    {{-- delete --}}
                    {!! Form::open(['url' => $url, 'method' => 'DELETE', 'class' => 'd-inline-block']) !!}
                    <button type="submit" class="btn btn-danger mr-2 crud-show-table--delete"
                            id="{{ $button['id'] ?? ''}}" data-id="{{ $item->getKey() }}">
                        削除
                    </button>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
        <div class="card-body pb-5">
            @yield('show_table_top')
            <div class="admin-show-table" id="admin-show-table">
                @include ('admin.crud.parts.show_table')
            </div>
            @yield('show_table_bottom')
        </div>
    </div>
    @yield('content_bottom')
@stop

@section('js')
    @parent
    @include('admin.crud.parts.show_js')
    @yield('script_detail')
@stop
