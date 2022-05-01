@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="text-center mb-5" >
                    <img style="width: 65%" src="{{asset("/images/logo/logo.jpg")}}" alt="Logo"
                         class="brand-image">
                </div>
                <form method="POST" action="{{ $login_url }}" class="card px-5 py-3 shadow">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('メールアドレス') }}</label>

                        <input id="email" type="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                               value="{{ old('email') }}" autocomplete="email" autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('パスワード') }}</label>

                        <input id="password" type="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                               autocomplete="current-password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  w-100">
                            {{ __('ログイン') }}
                        </button>
                    </div>

                    <div class="form-group">
                        <div class="col">
                            <div class="icheck-primary">
                                <p class="text-sm text-slate-700 opacity-70">パスワードを忘れた方は
                                    <a href="{{ route('admin.password.request') }}" class="underline">こちら</a></p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function () {
            window.localStorage.removeItem('time_fail_validate')
        })
    </script>
@endsection
