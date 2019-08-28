@extends('admin::layouts.master')

@section('content-header')
    <h1>
        {!! $classDesc!!}
        &middot;<small>{!! $methodDesc  !!}</small>
    </h1>

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">方法名: {{$class."::".$method}}</h3>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="javascript:history.back(-1)" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="javascript:history.back(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>

                <div class="form-horizontal box-body fields-group">
                    <form id="page-form" onkeydown="if(event.keyCode==13){return false;}">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>参数列表</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($param as $p)
                                <tr>
                                    <td style="width: 200px">{{$p}}</td>
                                    <td><input type="text" title="" class="form-control" name="{{$p}}" value=""></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>

                    <div style="margin: 10px">
                        <a id="page-submit" class="btn btn-info" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
                            提交
                        </a>
                    </div>

                    <div class="box-footer">
                        <div class="well well-sm">
                            返回结果：<br>
                            <textarea id="result" title="" class="form-control" rows="15"></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('style')
    <style>
        .individuation tr td{
            border-top:0px !important;
        }
    </style>
@stop

@section('script')
    <script>
        var POST_URL = '{{route("m.api.demo.result")}}';
        $( document ).ready(function(){
            $("#page-submit").click(function(){
                var className = '{{addslashes($class)}}';
                var data = {
                    'class' : className,
                    'method' : '{{$method}}',
                    'values' : {},
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                };
                $.each($('#page-form').serializeArray(), function(i, field) {
                    data.values[field.name] = field.value;
                });
                $.post(POST_URL, data, function(res){
                    var resObj = JSON.parse(res);
                    if ( resObj.code != 0 ) {
                        $("#result").html(resObj.msg);
                        return;
                    }

                    var jsonStr = resObj.data.result;
                    var jsonObj = JSON.parse(jsonStr);
                    var jsonPretty = JSON.stringify(jsonObj, null, '\t');

                    $("#result").html(jsonPretty);
                });
            });
        });
    </script>
@stop