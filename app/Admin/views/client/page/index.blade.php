@extends('admin::layouts.master')


@section('content-header')
    <h1>
        页面<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <ul class="nav nav-tabs nav-tabs-custom" style="margin-bottom: 0px">
                    @foreach($type as $key => $value)
                        <li {!! $key == Input::get('template') ?'class="active"' : '' !!}><a href="{!! route('m.client.page.list', ['template' => $key]) !!}">{!! $value !!}</a></li>
                    @endforeach
                    <li class="pull-right header"></li>
                </ul>
            </div>

            <div class="pull-right">
                @if(Input::get('template'))
                    <a href="{!! route('m.client.page.create', ['template' => Input::get('template')]) !!}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                @endif
            </div>

        <span>
        </span>

        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>编号</th>
                    <th>标题</th>
                    <th>模板类型</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>{!! $item->title !!}</td>
                        <td>{!! $item->templateName !!}</td>
                        <td>{!! $item->created_at !!}</td>
                        <td>
                            <div class="btn-group">
                                @if(!empty($item->route))
                                <a class="btn btn-default"  href="{!! route($item->route, ['cid' => $item->id]) !!}">
                                    列表
                                </a>
                                @endif
                                <a class="btn btn-default"  href="{!! route('m.client.page.edit', ['id' => $item->id]) !!}">
                                    编辑
                                </a>
                                <a class="btn btn-default item-delete"  href="javascript:void(0);" data-url="{!! route('m.client.page.destroy', ['id' => $item->id]) !!}" >
                                    删除
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->
    </div>

@stop

