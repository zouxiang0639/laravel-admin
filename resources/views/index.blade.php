<!DOCTYPE html>
<html lang="en" class="html-css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env('MIX_APP_TITLE')}}</title>
</head>
<body>
<div id="app">
    <div class="container main">
        <router-view />
    </div>
</div>
<script src="{{mix('/js/main.js', 'frontend')}}"></script>
<script src="{{mix('/js/manifest.js', 'frontend')}}"></script>
<script src="{{mix('/js/vendor.js', 'frontend')}}"></script>
</body>
</html>
