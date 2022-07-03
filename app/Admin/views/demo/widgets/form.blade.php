@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        示例<small>Form表单</small>
    </h1>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>
                </div>
                {!! $form !!}

                {{--<form method="POST"  accept-charset="UTF-8" class="form-horizontal box-body fields-group">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">

                        <span class="text-danger">*</span>
                        multiImage:
                    </label>
                    <div class="col-sm-7 switchOff">
                        <button type="button" onclick="addDetails()" class="btn btn-default btn-xs">+</button>


                        <table class="table table-bordered" id="contents">
                            <thead>
                                <tr>
                                    <th>上传图片</th>
                                    <th>上传图片</th>
                                    <th>删除</th>
                                </tr>
                            </thead>
                            <tbody id="contents">
                            </tbody >

                        </table>

                        <table>
                            <tfoot id="contents_clone" style="display: none">
                            <tr class="clone">
                                <td>
                                    <span class="mig_multiImage" >
                                    <a target="_blank" class="multiImage_a" href="http://my.simei.com/uploads/user2-160x160.jpg">
                                        <img class="multiImage_img" src="http://my.simei.com/uploads/user2-160x160.jpg" max-width="300" max-height="173" style="float:left;" >
                                    </a>
                                    </span>
                                    <a style="margin-left: 10px" onclick="multiImageUpload(this)" href="javascript:;" class="btn btn-default btn-xs">上传图片</a>
                                    <input name="multiImage[img][]" class="multiImage_input" type="hidden" value="user2-160x160.jpg">
                                </td>

                                <td><input name="multiImage[cc][]" type="text"></td>
                                <td style="text-align: center;">
                                    <button type="button" onclick="deleteDetails(this) " class="btn btn-default btn-xs">-</button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                    <script>
                        function deleteDetails(obj) {
                            $(obj).parent().parent().remove();
                        }

                        /**
                         * 添加发票明细
                         */
                        function addDetails (boole) {
                            if (boole != true) {
                                $('#contents').append($("#contents_clone .clone").clone());
                            }

                        }

                        function multiImageUpload (obj) {

                            layer.open({
                                type: 2,
                                title: '上传文件',
                                maxmin: true,
                                area: ['500px', '450px'],
                                content: '{{route('m.system.upload.show', ['ext' => '','size'=>'300mb'])}}',
                                btn:['保存', '关闭'],
                                yes:function(index, layero) {
                                    var file = $(layero).find("iframe")[0].contentWindow.getFile();
                                    if(file) {
                                        $(obj).next().val(file.path);
                                        $(obj).prev().find('img').attr("src",'http://my.simei.com/uploads/'+file.path).show();
                                        $(obj).prev().find('a').attr("href",'http://my.simei.com/uploads/'+file.path);
                                        layer.close(index);
                                    } else {
                                        swal('请上传图片', '', 'error');
                                    }

                                }
                            });
                        }

                        $(function() {
                            addDetails()
                        })
                    </script>
                </form>--}}
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        function formValidate()
        {
            //解决ckeditor编辑器 ajax上传问他
            if(typeof CKEDITOR=="object"){
                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        }
        var initialAjAx = {
            "url":"{!! route('m.demo.widgets.formPost') !!}",
            "backUrl":"{!! route('m.role.list') !!}"
        };

    </script>
@stop
