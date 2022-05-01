@extends('layouts.master')
@section('content')
    {{ Breadcrumbs::render('page', '無料会員登録') }}
    <div id="vue">
        <register-form :business-form='{!! json_encode(BUSINESS_FORM) !!}' :prefecture-form="{{json_encode($prefectures)  }}"></register-form>
    </div>
    <div class="block">
        @include('elements.download')
    </div>
@stop
@section('script')
    <script src="{{ mix('js/vue.js') }}"></script>
@endsection
