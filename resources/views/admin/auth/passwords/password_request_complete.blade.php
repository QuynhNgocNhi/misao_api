@extends('adminlte::auth.auth-page')

@section('auth_body')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
                <h3 class="text-center">パスワード変更</h3>
                <div class="card">
                    <div class="card-body">
                        <p>ご入力いただきましたメールアドレス宛にパスワード変更用URLを記載したメールを送信いたしました。<br>
                            メール内に記載されているURLにアクセスいただき登録内容を変更してください</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
