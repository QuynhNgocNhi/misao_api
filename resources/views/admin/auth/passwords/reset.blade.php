@extends('adminlte::auth.auth-page', ['auth_type' => 'reset'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="text-center mb-5" >
                    <img style="width: 65%" src="{{asset("images/logo/logo.jpg")}}" alt="Steerlink Logo"
                         class="brand-image">
                </div>
                <form method="POST" action=" {{ route('admin.password.update') }} " class="card px-5 py-3 shadow">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <input
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                               value="{{ $email }}" autocomplete="email" autofocus type="hidden">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('パスワード') }}</label>
                        <input id="email" type="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                               value="{{ old('password') }}" autocomplete="password" autofocus>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('パスワード確認') }}</label>
                        <input id="email" type="password"
                               class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation"
                               value="{{ old('password_confirmation') }}" autocomplete="password_confirmation" autofocus>

                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  w-100">
                            送信
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop