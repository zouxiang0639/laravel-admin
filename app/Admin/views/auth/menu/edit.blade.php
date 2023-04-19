@extends('admin::layouts.master')

@section('content-header')
    <h1>
        菜单<small>编辑</small>
    </h1>
@stop
@section('content')

    <div class="row"><div class="col-md-12"><div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{!! route('m.menu.list') !!}" class="btn btn-sm btn-default">
                                <i class="fa fa-list"></i>&nbsp;列表
                            </a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
              {!! $form !!}
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.menu.update', ['id' => $info->id]) !!}",
            "backUrl":"{!! route('m.menu.list') !!}"
        }
    </script>
@stop