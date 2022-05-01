@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>会員登録申請を受け付けました。</p>
        <br>
        <p>会社名：{{ $companyName }}</p>
        <br>
        <p>========================</p>
        <p>詳細はアイナビトラックにログインしてご確認ください。</p>
        <a href="{{ route('account.index') }}">{{ route('account.index') }}</a>
    </div>
@endsection

