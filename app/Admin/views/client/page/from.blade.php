<?php
use App\Consts\Admin\Client\PageTemplateConst;
?>

{!! Form::open(['class' => 'form-horizontal box-body fields-group']) !!}
<div class="box-header">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">基本信息</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">其它</a></li>
    </ul>

    <div class="box-tools" style="margin-top: 5px">
        <div class="btn-group pull-right" style="margin-right: 10px">
            <a href="{!! route('m.client.page.list', ['template' => Input::get('template')]) !!}" class="btn btn-sm btn-default">
                <i class="fa fa-list"></i>&nbsp;列表
            </a>
        </div> <div class="btn-group pull-right" style="margin-right: 10px">
            <a href="JavaScript:history.go(-1)" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
        </div>
    </div>
</div>
<div class="tab-content">


    <div class="tab-pane active" id="tab_1">
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">

                <span class="text-danger">*</span>
                标题:
            </label>
            <div class="col-sm-7 title">
                <div class="input-group" style="width:100%">
                    {!!  Form::text('title', isset($info) ? $info->title : '' ,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">

                <span class="text-danger">*</span>
                模版:
            </label>
            <div class="col-sm-7 template">
                <div class="input-group" style="width:100%">
                    {!!  Form::select('template', PageTemplateConst::desc(), isset($info) ? $info->template : Input::get('template'),['class' => 'form-control', 'disabled']) !!}
                    {!!  Form::hidden('template', isset($info) ? $info->template : Input::get('template')) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">

                描述:
            </label>
            <div class="col-sm-7 comment">
                <div class="input-group" style="width:100%">
                    {!!  Form::textarea('comment', isset($info) ? $info->comment : '' ,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">

                内容:
            </label>
            <div class="col-sm-7 content">
                <div class="input-group" style="width:100%">
                    {!!  Form::ckeditor('contents', isset($info) ? $info->contents : '') !!}
                </div>
            </div>
        </div>

    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="tab_2">
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">
                缩率图:
            </label>
            <div class="col-sm-7 picture">
                <div class="input-group" style="width:100%">
                    {!!  Form::imageOne('picture', isset($info) ? $info->picture : '', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">
                <span class="text-danger">*</span>
                SEO关键字:
            </label>
            <div class="col-sm-7 keywords">
                <div class="input-group" style="width:100%">
                    {!!  Form::textarea('keywords', isset($info) ? $info->keywords : '' ,['class' => 'form-control']) !!}
                </div>
                <span class="help-block">
                    <i class="fa fa-info-circle"></i>&nbsp;（网站搜索引擎关键字） 多个用 ( , )隔开
                </span>
            </div>

        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">
                <span class="text-danger">*</span>
                SEO描述:
            </label>
            <div class="col-sm-7 description">
                <div class="input-group" style="width:100%">
                    {!!  Form::textarea('description', isset($info) ? $info->description : '' ,['class' => 'form-control']) !!}
                </div>
                <span class="help-block">
                    <i class="fa fa-info-circle"></i>&nbsp;（网站搜索引擎描述）
                </span>
            </div>
        </div>

    </div>
    <div class="box-footer">
        <a class="btn btn-info col-md-offset-2 form-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
            提交
        </a>
    </div>

    <!-- /.tab-pane -->
</div>
{!! Form::close() !!}

@section('script')
    @parent
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
    </script>
@stop