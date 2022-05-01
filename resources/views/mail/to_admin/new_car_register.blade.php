@extends('mail.layout')

@section('body')
    <div style="padding: 20px 0;">
        <p>車両掲載申請を受け付けました。</p>
        <br>
        <p>車両番号：{{ $contact_code }}</p>
        <p>会社名：{{ $company_name }}</p>
        <p>車両名：{{ $car_name }}</p>
        <br>
        <p>========================</p>
        <p>詳細はアイナビトラックにログインしてご確認ください。</p>
        <p><a href="{{ $link = route('admin.car-approve.show', $car_id) }}">{{ $link }}</a></p>
    </div>
@endsection
