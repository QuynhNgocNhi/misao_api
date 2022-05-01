@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )

@if (config('adminlte.use_route_url', false))
    @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
@else
    @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
@endif

@section('auth_header', __('auth.account_lockout.form_title'))

@section('auth_body')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form>

        {{-- Notification block account text --}}
        <div class="form-group mb-3">
            {!! __('auth.account_lockout.notification') !!}
        </div>

        {{-- Link back to top --}}
        <a type="button"
           class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}"
           href="{{ route('admin.auth.login') }}">
            <span class="fas fa-share-square"></span>
            {{ __('auth.account_lockout.btn_back_login') }}
        </a>

    </form>

@stop

@section('js')
    <script>
        $(document).ready(function () {
            window.localStorage.removeItem('time_fail_validate')
        })
    </script>
@endsection
