@extends('emails.layout')

@section('body')
    <div style="padding: 20px 0;">
        @if(count($mailTemplate->attachments) > 0)
            <div id="attachments" style="padding: 10px 0;">
                <p>
                    こちらのメールには添付されたファイルがございます。<br>
                    下記のリンクよりダウンロードを行なってください。
                </p>
                @foreach($mailTemplate->attachments as $attachment)
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

        <p>{!! nl2br(e($body)) !!}</p>

        <div style="padding: 10px 0;">
            ※ 本メールはシステムより自動配信されています。<br>
            本メールのメールアドレスへの返信は受付けておりませんので、ご了承ください。
        </div>
    </div>
@endsection
