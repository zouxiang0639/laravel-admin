<meta http-equiv="Content-Type" content="text/html; charset=GBK">

@if(!empty(config("config")) && !empty(config("config")["ico"]))
    <link href="{{config("config")["ico"]}}" rel="shortcut icon">
@endif

<title>{{$seo['title']}}</title>
<meta name="keywords" content="{{$seo['keywords']}}">
<meta name="description" content="{{$seo['description']}}">
