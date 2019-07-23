<?php
use App\Consts\Admin\Client\NavBindTypeConst;
?>
@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/nestable/nestable.css") }}">
@stop
@section('content-header')
    <h1>
        导航设置<small>列表</small>
    </h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            {!! $list !!}
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12"><div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">新增</h3>
                        </div>
                        {!! $form !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script src="{{  assets_path("/lib/nestable/jquery.nestable.js") }}"></script>
    <script>
        var param = {
            "bindPage":"{!! NavBindTypeConst::BIND_PAGE !!}", //绑定页面
            "url":"{!! route('m.client.nav.list') !!}", //列表
        };

        var initialAjAx = {
            "url":"{!! route('m.client.nav.store') !!}",
            "backUrl":"{!! route('m.client.nav.list', ['category' => Input::get('category')]) !!}"
        };
        $(function(){
            $("select[name=bind_type]").change(function(){
                var key = $(this).val();
                if(key == param.bindPage) {
                    $('#page_html').show();
                    $('#url_html').hide();
                } else {
                    $('#page_html').hide();
                    $('#url_html').show();
                }
            }).trigger('change');

            $('select[name=category]').change(function() {
                var key = $(this).val();
                window.location.href = param.url+'?category='+key;
            })
        })
    </script>
    @stop