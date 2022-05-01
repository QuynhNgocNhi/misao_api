@extends('emails.layout')

@section('body')
    <tr>
        <td style="padding: 20px;">
            <p>
                {!! nl2br($body) !!}
            </p>
        </td>
    </tr>
@endsection

@section('button')
    @if ($buttonUrl)
    <tr>
        <td style="padding: 10px 20px; text-align: center">
            <a href="{{ $buttonUrl }}"
               target="_blank" style="background: white!important; border: 1px solid #F16863!important;
                       border-radius: 3px; color: #F16863; font-weight: 500; text-align: center;
                       cursor: pointer; display: inline-block; width: auto; padding: 10px 20px;
                       margin: 0 auto; white-space: nowrap!important;
                       text-decoration: none!important;">{{ $buttonText }}</a>

        </td>
    </tr>
    <tr>
        <td style="padding: 20px 20px 40px;">
            <p>
                もし "{{ $buttonText }}"ボタンを押せない場合は、以下のURLをコピーしてブラウザのアドレスバーに貼り付けてください。
            </p>
            <p style="word-break: break-all;">
                {{ $buttonUrl }}
            </p>
        </td>
    </tr>
    @endif
@endsection
