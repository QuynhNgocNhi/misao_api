<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @if(isset($meta_seo))
        {!! $meta_seo ? $meta_seo->renderMetaSeo() : '' !!}
    @else
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
        <title>@yield('title', 'Steerlink')</title>
    @endif
    @if(auth()->user())
        <meta name="user_id" content="{{ auth()->id() }}" id="meta-user-id">
    @endif
    <link rel="stylesheet" href="{{ asset('libs/fontawesome-free/css/all.min.css') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('elements.header')
@yield('content')
@include('elements.menu_bottom')
@include('elements.footer')
<script src="{{ mix('js/app.js') }}"></script>
@yield('script')
</body>
</html>
