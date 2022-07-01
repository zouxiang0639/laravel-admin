<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    @include('web::partials.style')
    @yield('style')

</head>

<body>

@include('web::partials.header')
@include('web::partials.menu')

@yield('content')

@include('web::partials.footer')

@include('web::partials.script')
</body>
</html>
