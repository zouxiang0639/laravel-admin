<?php
use App\Consts\Common\UseStatusConst;
use App\Consts\Role\TypographerAuthDisplayConst;
?>

@extends('admin::layouts.master')

@section('content-header')
    <h1>
        {!! $title or '系统操作日志' !!}

    </h1>
@stop

@section('content')

    {{--搜索--}}
    {!! Form::open(['method' => 'GET', 'class'=>'form-inline panel panel-body']) !!}

    <div class="form-group">
        <label>操作人:</label>
        {!! Form::text('operator', array_get(Input::get(), 'operator'), ['class'=>"form-control"]) !!}
    </div>

    {!! Form::submit('查询', ['id'=>'', 'class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}

    <table class="table table-hover">
        <thead>
        <tr>
            <th>功能版块</th>
            <th>业务编号</th>
            <th>操作类型</th>
            <th>操作人</th>
            <th>操作IP</th>
            <th>操作url</th>
            <th>操作时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{!! $item->function_block !!}</td>
                <td>{!! $item->business_no ?: '-' !!}</td>
                <td>{!! $item->action !!}</td>
                <td>{!! $item->operatorName !!}</td>
                <td>{!! $item->ip !!}</td>
                <td>{!! $item->url !!}</td>
                <td>{!! $item->updated_at !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {!! $list->appends(Input::get())->render() !!}
    </div>
@stop
@section('script')
    <script>
        $(function(){
            $('.typographer_status').click(function(){
                var url = $(this).attr('href');
                var status = $(this).attr('status');

                var data = new FormData();
                data.append('status', status);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {
                            alert(res.msg);
                        }else {
                            window.location.href = document.URL ;
                        }

                    }

                });
                return false;
            });
        })
    </script>
@stop
