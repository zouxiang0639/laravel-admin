@extends('admin::layouts.master')


@section('content-header')
    <h1>
       搜索管理<small>列表</small>
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
                </form>
            </div>

            <div class="pull-right">
                <a href="#" class="btn btn-sm btn-success generate">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;生成搜索
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
                    <th>Url</th>
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
                            <td>{!! $item->url !!}</td>
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


@section('script')
    <script>
        $(function(){
            //提交数据
            var locked = true;
            $('.generate').click(function() {
                var _this = $(this);
                if (! locked) {
                    return false;
                }
                locked = false;
                _this.attr('disabled',true);

                $.ajax({
                    url: "{!! route('m.client.search.generate') !!}",
                    type: 'POST',
                    data: {
                        "_token":$('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {
                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = '';
                        }
                    },
                    error:function () {
                        _this.attr('disabled',false);
                        locked = true;
                    }
                });
            });
        })
    </script>
@stop