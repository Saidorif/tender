<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>e-TENDER</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ $baseUrl. 'fonts/peicon/css/peicon.css' }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ $baseUrl. 'css/fonts.css?version=1.1.3' }}">
        <link rel="stylesheet" href="{{ $baseUrl. 'css/app.css?version=1.1.3'}}">
        <link rel="stylesheet" href="{{ $baseUrl. 'css/fancybox.css?version=1.1.3' }}">
        <link rel="stylesheet" href="{{ $baseUrl. 'css/style.css?version=1.1.3' }}">

    </head>
    <body>
        <div id="app">
            <Master/>
        </div>
        <script src="{{ $baseUrl. 'js/app.js?version=0.0.51' }}"></script>
        <script src="{{ $baseUrl. 'js/fancybox.js' }}"></script>
        <script src="{{ $baseUrl. 'js/print.js' }}"></script>
    </body>
</html>
