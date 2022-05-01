@extends('layouts.master')
@section('content')
    {{ Breadcrumbs::render('reset_password') }}
    <div id="vue">
        <div class="py-8 bg-slate-200">
            <h2 class="text-3xl text-center text-slate-700">パスワードを忘れた方</h2>
        </div>
        <div class="pt-10 pb-16">
            <div class="container">
                <password-email-form></password-email-form>
            </div>
        </div>
    </div>
    <div class="block">
        @include('elements.download')
    </div>
@stop
@section('script')
    <script src="{{ mix('js/vue.js') }}"></script>
@endsection
