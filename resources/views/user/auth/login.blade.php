@extends('layouts.master')
@section('content')
    {{ Breadcrumbs::render('login') }}
    <div id="vue">
        <div class="py-8 bg-slate-200">
            <h2 class="text-3xl text-center text-slate-700">ログイン</h2>
        </div>
        <div class="pt-10 pb-16">
            <div class="container">
                <login-form url-forget-password="{{ route('password.request')  }}" redirect-url="{{ redirect()->intended('/')->getTargetUrl() }}"></login-form>
                <div class="grid grid-cols-12 gap-8 ">
                    <label class="col-span-12 lg:col-span-4"></label>
                    <div class="col-span-12 lg:col-span-4">
                        <p class="text-center mb-4">会員登録がお済みでない方</p>
                        <a href="{{ route('register') }}" class="btn btn-icon btn-primary w-full h-14 px-16">無料会員登録
                            <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.download')
@stop
@section('script')
    <script src="{{ mix('js/vue.js') }}"></script>
@endsection
