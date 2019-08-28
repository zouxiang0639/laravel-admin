@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        {!! $title !!}<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">

            </div>

            <div class="pull-right">
                @if(Input::get('type'))
                    <a href="{!! route('m.other.advert.create', ['type' => Input::get('type')]) !!}" class="btn btn-sm btn-success">
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
                    <th>SDK</th>

                </tr>
                @foreach ($list as $method => $desc)
                    <tr>
                        <td>
                            <a href="{{route('m.api.demo.detail', ['class'=>$class, 'method'=>$method])}}" class="list-group-item">{{$desc}}[{{$class}}::{{$method}}]</a>
                        </td>
                    </tr>

                @endforeach
            </table>
        </div>

        <div class="box-footer clearfix">

        </div>
        <!-- /.box-body -->
    </div>

@stop

@section('script')

@stop