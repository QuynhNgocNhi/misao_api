@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@push('js')
    <script src="{{ mix('js/admin.js') }}" defer></script>
@endpush

@section('content_header')
    @yield('content_header_label')

    @include('admin.block.flash')
@stop
