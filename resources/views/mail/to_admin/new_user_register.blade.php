@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>会員登録申請を受け付けました。</p>
        <br>
        <p>会社名：{{ $company_name }} </p>
        <br>
        <p>========================</p>
        <p>詳細はアイナビトラックにログインしてご確認ください。</p>
        <p><a href="{{ $link = route('admin.user-approve.show', $user_id) }}">{{ $link }}</a></p>
    </div>
@endsection

