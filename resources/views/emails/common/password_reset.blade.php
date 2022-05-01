@extends('emails.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p> アイナビ運営事務局です。</p>
        <br/>
        <p>
            下記URLからパスワードの設定を行なってください。<br/>
            {{ $url }}<br/>
            有効期限：{{ $expired }}
        </p>
        <br>
        <p>------------------------------------------</p>
        <p>アイナビサポートデスク</p>
        <p>お問い合わせ：<a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></p>
        <p>------------------------------------------</p>
    </div>
@endsection
