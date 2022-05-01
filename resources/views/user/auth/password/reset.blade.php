@extends('layouts.master')
@section('content')
    {{ Breadcrumbs::render('reset_password') }}
    @if($isTokenExpired)
        <div class="py-8">
            <h2 class="text-3xl text-center text-slate-700">パスワード再設定用のトークンが不正です。</h2>
        </div>
    @else
        <div id="vue">
            <div class="py-8 bg-slate-200">
                <h2 class="text-3xl text-center text-slate-700">パスワード再設定</h2>
            </div>
            <div class="pt-10 pb-16">
                <div class="container">
                    <password-reset-form token="{{ $token }}" email="{{ $email }}"></password-reset-form>
                </div>
            </div>
        </div>
    @endif
    <div class="block">
        @include('elements.download')
    </div>
@stop
@section('script')
    <script src="{{ mix('js/vue.js') }}"></script>
@endsection
