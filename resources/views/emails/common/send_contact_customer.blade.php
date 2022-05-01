@extends('emails.layout')

@section('body')
    @if($historyEmail->attachments && count($historyEmail->attachments))
        <div id="attachments" style="padding: 10px 0;">
            <p>
                こちらのメールには添付されたファイルがございます。<br>
                下記のリンクよりダウンロードを行なってください。
            </p>
            @foreach($historyEmail->attachments as $attachment)
                <p>
                    <a class="btn_download"
                       href="{{ $attachment->c_attachment->full_file_path }}"
                       download
                    >
                        {{ $attachment->c_attachment->name }}
                    </a>
                </p>
            @endforeach
        </div>
        <hr>
    @endif

    <!-- 本文 -->
    <div id="body" style="padding: 20px 0 10px 0;">{!! nl2br(e($historyEmail->body)) !!}</div>

    <div style="padding: 10px 0;">
        ※ 本メールのメールアドレスは送信専用のため、返信は受付けておりません。<br>
        お手数をおかけいたしますが、返信につきましては下記のメール返信フォームから行なっていただくようお願い申し上げます。
    </div>
    <div style="padding: 10px 0;">
        <a href="{{ $responseUrl }}">
            メール返信フォーム
        </a>
    </div>
@endsection
