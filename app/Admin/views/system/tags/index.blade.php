@extends('admin::layouts.master')

@section('style')
    <link rel="stylesheet" href="{{  assets_path("/lib/bootstrap3-editable/css/bootstrap-editable.css") }}">
@stop

@section('content-header')
    <h1>
        标签<small>列表</small>
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left ">
                <ul class="nav nav-tabs nav-tabs-custom" style="margin-bottom: 0px">
                    @foreach($tagsType as $key => $value)
                        <li {!! $key == Input::get('type') ?'class="active"' : '' !!}><a href="{!! route('m.system.tags.list', ['type' => $key]) !!}">{!! $value !!}</a></li>
                    @endforeach
                    <li class="pull-right header"></li>
                </ul>
            </div>

            <div class="pull-right">
                <a href="{!! route('m.system.tags.create', ['type' => Input::get('type')]) !!}" class="btn btn-sm btn-success">
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
                    <th>热度</th>
                    <th>标签名称</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{!! $item->id !!}</td>
                        <td>
                            <a href="javascript:;" class="hot" data-pk="{!! $item->id !!}">{!! $item->hot !!}</a>
                        </td>
                        <td>{{ $item->tag_name }}</td>
                        <td class="switch_submit" data-href="{!! route('m.system.tags.status', ['id' => $item->id]) !!}">
                            {!! Form::switchOff('switch_submit', $item->status) !!}
                        </td>
                        <td>{!! $item->created_at !!}</td>
                        <td>{!! $item->updated_at !!}</td>
                        <td>
                            <a href="{!! route('m.system.tags.edit', ['id' => $item->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" data-url="{!! route('m.system.tags.destroy', ['id' => $item->id]) !!}" class="item-delete">
                                <i class="fa fa-trash"></i>
                            </a>
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
    <div class="row form-group">
        <label class="col-md-2 text-right">
            <span class="text-danger">*</span>
            卡面印刷文件:
        </label>
        <div class="col-md-6 print_file">
            <input type="hidden" name="print_file" value="">
            <span id="print-file-name">
                <img src="{!! get_file_img('/2019/12/17/e317c6ba9775db2bba60f9f8e7081079.JPG') !!}" width="300" height="173" style="float:left">
			</span>

            <a id="print-file" href="javascript:;" class="btn btn-default btn-xs">上传印刷文件</a>
        </div>
    </div>

@stop

@section('script')
    <script src="{{  assets_path("/lib/bootstrap3-editable/js/bootstrap-editable.min.js") }}"></script>
    <script src="{{  assets_path("/lib/layer-alert/layer.js") }}"></script>
    <script>
        $(function(){
            $('.hot').editable({
                url: "{!! route('m.system.tags.hot') !!}",
                type: 'text',
                params: {
                    "_method": "PUT",
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                pk: $(this).attr('data-pk'),//唯一标示值
                title: '修改',
                name: 'hot',
                success: function(value) {
                    $(this).text(value);
                }
            });


          $('#ico').click(function(){
            layer.open({
              type: 2,
              title: '上传文件',
              maxmin: true,
              area: ['500px', '450px'],
              content: 'http://my.purchase.com/admin/system/upload/show?ext=&size=300mb',
            btn:['保存', '关闭'],
              yes:function(index, layero) {
              var file = $(layero).find("iframe")[0].contentWindow.getFile();
              if(file) {
                $('input[name=ico]').val(file.path);
                $('#mig_ico').find('img').attr("src",'http://my.purchase.com/uploads/'+file.path);
                layer.close(index);
              } else {
                swal('请上传图片', '', 'error');
              }

            }
          });


          $('#print-file').click(function(){
            layer.open({
              type: 2,
              title: '上传文件',
              maxmin: true,
              area: ['500px', '450px'],
              content: '{!! route('m.system.upload.show', ['ext' => '','size'=>'300mb']) !!}',
              btn:['保存', '关闭'],
              yes:function(index, layero) {
                var file = $(layero).find("iframe")[0].contentWindow.getFile();
                if(file) {
                  $('input[name=print_file]').val(file.path);
                  $('#print-file-name').find('img').attr("src",'{!! get_file_img('') !!}'+file.path);
                  layer.close(index);
                } else {
                  swal('请上传图片', '', 'error');
                }

              }
            });
          });
        })
    </script>
@stop
