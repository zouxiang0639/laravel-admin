@extends('admin::layouts.master')


@section('content-header')
    <h1>
        {!! $page->title !!}<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <form class="form-inline" name="search" action="">
                    <div class="input-group input-group-sm ">
                        <input name="title" value="{!! Input::get('title') !!}" class="form-control pull-right" placeholder="标题" type="text">
                        <div class="input-group-btn">
                            <button id="flow-search" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                    <input name="cid" type="hidden" value="{!! Input::get('cid') !!}">
                </form>
            </div>

            <div class="pull-right">
                <a href="{!! route('m.client.page.list', ['template' => $page->template]) !!}" class="btn btn-sm btn-default">
                    <i class="fa fa-list"></i>&nbsp;列表
                </a>
                <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>

                <a href="{!! route('m.client.news.create', ['cid' => Input::get('cid')]) !!}" class="btn btn-sm btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
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
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @if($list->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center">暂无数据</td>

                    </tr>
                @else
                    @foreach($list as $item)
                        <tr>
                            <td>{!! $item->id !!}</td>
                            <td>{!! $item->title !!}</td>
                            <td>{!! $item->created_at !!}</td>
                            <td class="switch_submit" data-href="{!! route('m.client.news.status', ['id' => $item->id, 'cid' => $page->id]) !!}">
                                {!! Form::switchOff('switch_submit', $item->status) !!}
                            </td>
                            <td>
                                <div class="btn-group">

                                    <a class="btn btn-default"  href="{!! route('m.client.news.edit', ['id' => $item->id, 'cid' => $page->id]) !!}">
                                        编辑
                                    </a>
                                    <a class="btn btn-default item-delete"  href="javascript:void(0);" data-url="{!! route('m.client.news.destroy', ['id' => $item->id, 'cid' => $page->id]) !!}" >
                                        删除
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

        <div class="box-footer clearfix">
            {!! $list->appends(Input::get())->render() !!}
        </div>
        <!-- /.box-body -->
    </div>

@stop
