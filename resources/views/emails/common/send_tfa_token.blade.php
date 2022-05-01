@extends('emails.layout')

@section('body')
    <div style="padding: 20px 0;">下記の二段階認証コードを入力欄に入力してください。</div>
    <div style="padding-bottom: 20px;">{{ $token }}</div>
    <div style="padding-bottom: 20px;">
        コードの有効期限は{{ config('constant.tfa_token_expire_time') }}分間です。<br>
        {{ config('constant.tfa_token_max_trial_count') }}回以上コードを間違えた場合アカウントがロックされますのでご注意ください。
    </div>
@endsection
