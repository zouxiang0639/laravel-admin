<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ assets_path("/lib/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ assets_path("/lib/font-awesome/css/font-awesome.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ assets_path("/lib/AdminLTE/dist/css/AdminLTE.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ assets_path("/lib/AdminLTE/plugins/iCheck/square/blue.css") }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{ get_file_img(config('admin.login_background_image'))}}) no-repeat;background-size: cover;"@endif>

<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('m.home') }}"><b style="color: white">{{config('admin.name')}}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>

        <form action="{{ route('m.postLogin') }}" method="post">
            <div class="form-group has-feedback {!! !$errors->has('username') ?: 'has-error' !!}">

                @if($errors->has('username'))
                    @foreach($errors->get('username') as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
                    @endforeach
                @endif

                <input type="input" class="form-control" placeholder="请输入用户名" name="username" value="{{ old('username') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

                @if($errors->has('password'))
                    @foreach($errors->get('password') as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
                    @endforeach
                @endif

                <input type="password" class="form-control" placeholder="请输入密码" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {!! !$errors->has('captcha') ?: 'has-error' !!}">


                    @if($errors->has('captcha'))
                        @foreach($errors->get('captcha') as $message)
                            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
                        @endforeach
                    @endif


                <div class="col-md-12 input-group ">
                    <input name="captcha" value="" class="form-control pull-right" placeholder="请输入验证码" type="text">
                    <div class="input-group-btn">
                        <img src="{{captcha_src()}}" style="cursor: pointer;border: 1px solid #ccc;" onclick="this.src='{{captcha_src()}}'+Math.random()">
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- /.col -->
                <div class="col-xs-4 col-md-offset-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ assets_path("/lib/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ assets_path("/lib/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ assets_path("/lib/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
