@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

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
                <form method="POST" action=" {{ route('admin.password.email') }} " class="card px-5 py-3 shadow">
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
                        <button type="submit" class="btn btn-primary  w-100">
                            送信
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
