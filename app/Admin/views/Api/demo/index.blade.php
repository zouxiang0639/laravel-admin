@extends('admin::layouts.master')

@section('style')
@stop

@section('content-header')
    <h1>
        所有接口<small>列表</small>
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
                @foreach($list as $class => $item)
                    <tr>
                        <td> <a href="{{route('m.api.demo.methods', ['class'=>$class])}}" class="list-group-item">{{$item}}:[[{{$class}}]]</a></td>
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