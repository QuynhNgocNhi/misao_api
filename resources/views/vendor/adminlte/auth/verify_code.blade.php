@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )

@if (config('adminlte.use_route_url', false))
    @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
@else
    @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
@endif

@section('auth_header', __('auth.verify_code.sent_code'))

@section('auth_body')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('admin.auth.verify_tfa_token') }}" method="post">
        {{ csrf_field() }}

        <input type="hidden" name="email" value="{{ $email }}">

        <input type="hidden" name="isFailValidate" value="{{ session('fail') ?? false }}" id="is-fail-validate">

        <div class="mb-1 text-center">
            <div class="">{{ __('auth.verify_code.enter_code') }}</div>
        </div>

        {{-- Code field --}}
        <div class="form-group mb-3">
            <input type="text" name="code" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   placeholder="{{ __('auth.verify_code.placeholder') }}" autofocus>
            <div id="error-message" class="invalid-feedback text-center">
            </div>
        </div>

        <div class="mb-4">
            {{ __('auth.verify_code.new_code_send') }}<br>
            ※{{ config('constant.throttles_verify_code.max_attempts') }}{{ __('auth.verify_code.account_locked') }}
        </div>

        {{-- Verify code button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-share-square"></span>
            {{ __('auth.verify_code.btn_submit') }}
        </button>

    </form>

@stop

@section('auth_footer')
    {{-- Back to login link --}}
    <p class="my-0">
        <a href="{{ route('admin.auth.login') }}">
            {{ __('auth.verify_code.btn_back_to_login') }}
        </a>
    </p>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            let timeFailValidate = window.localStorage.getItem('time_fail_validate')
            if (!timeFailValidate) {
                window.localStorage.setItem('time_fail_validate', 1)
            } else {
                timeFailValidate++;
                window.localStorage.setItem('time_fail_validate', timeFailValidate)
            }
            let isFailValidate = $('#is-fail-validate').val()
            if (isFailValidate) {
                $('#error-message').text(`新しいコードがメールで送信されました（${timeFailValidate}回目）`).css('display', 'block')
            }
        })
    </script>
@endsection
