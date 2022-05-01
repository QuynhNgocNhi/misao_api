@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>アイナビ運営事務局です。</p>
        <p>会員登録申請を受け付けました。</p>
        <br>
        <p>事務局からご連絡をさせて頂きますので、お待ちください。</p>
        <br>
        <p>------------------------------------------</p>
        <p>アイナビサポートデスク</p>
        <p>お問い合わせ：<a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></p>
    </div>
@endsection


