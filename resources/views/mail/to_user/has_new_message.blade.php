@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>アイナビ運営事務局です。</p>
        <p>新着メッセージがあります。</p>
        <br>
        <p>{{$companyName}}さんからのメッセージがあります。</p>
        <br>
        <p>========================</p>
        <p>詳細はアイナビトラックにログインしてご確認ください。</p>
        <a href="{{$url}}">{{$url}}</a>
        <br>
        <p>------------------------------------------</p>
        <p>アイナビサポートデスク</p>
        <p>お問い合わせ：<a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></p>
        <p>------------------------------------------</p>
    </div>
@endsection


