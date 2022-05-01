@extends('emails.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>
            パスワードの再設定申込みを受け付けました。<br/>
            下記のページにアクセスして、新しいパスワードを再設定してください。
        </p>
        <p>
            <a href="{{ $url }}"
               target="_blank" style="background: white!important; border: 1px solid #F16863!important;
                       border-radius: 3px; color: #F16863; font-weight: 500; text-align: center;
                       cursor: pointer; display: inline-block; width: auto; padding: 10px 20px;
                       margin: 0 auto; white-space: nowrap!important;
                       text-decoration: none!important;">パスワードの再設定を行う</a>
        </p>
        <p>
            URLの有効期限は {{ $expired }} までとなります。<br/>
            有効期限が過ぎている場合は、ログイン画面から再度パスワードの再設定の申込を行ってください。
        </p>
    </div>

@endsection
