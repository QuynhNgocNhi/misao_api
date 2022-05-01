@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>アイナビ運営事務局です。</p>
        <p>在庫確認・商談申込を受け付けました。</p>
        <br>
        <p>掲載企業からの返答をお待ちください。</p>
        <br>
        <p>------------------------------------------</p>
        <p>アイナビサポートデスク</p>
        <p>お問い合わせ：<a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></p>
        <p>------------------------------------------</p>
    </div>
@endsection
