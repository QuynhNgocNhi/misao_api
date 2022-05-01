<!DOCTYPE html>
<html lang="ja">
<head>
    <title></title>
    <meta charset="utf-8" />
    <meta name="description" content="京阪電鉄不動産CRM" />
    <meta name="keywords" content="京阪電鉄不動産CRM" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ mix('css/common.css') }}">
</head>
<body>
    <div id="app-form"></div>

    {{-- Ziggy blade directive : vueファイル内で routes() を使えるようにする --}}
    @routes

    <script type="text/javascript" src="{{ mix('js/app-form.js') }}" defer></script>
</body>
</html>
