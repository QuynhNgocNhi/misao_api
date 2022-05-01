@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>アイナビ運営事務局です。</p>
        <p>車両掲載の審査結果をお知らせします。</p>
        <br>
        <p>{{ $approveReason }}</p>
        <br>
        <br>
        <p>------------------------------------------</p>
        <p>アイナビサポートデスク</p>
        <p>お問い合わせ：<a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></p>
        <p>------------------------------------------</p>
    </div>
@endsection
