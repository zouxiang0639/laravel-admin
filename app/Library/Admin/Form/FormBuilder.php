<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Consts\Common\WhetherConst;
use App\Library\Admin\Consts\StyleTypeConst;

class FormBuilder extends \Collective\Html\FormBuilder
{

    private $resource = [
        //开关
        'bootstrap-switch.min.css' => '/lib/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        'bootstrap-switch.min.js' => '/lib/bootstrap-switch/dist/js/bootstrap-switch.min.js',

        //上传文件
        'fileinput.min.css' => '/lib/bootstrap-fileinput/css/fileinput.min.css?v=4.3.7',
        'fileinput.min.js' => '/lib/bootstrap-fileinput/js/fileinput.min.js?v=4.3.7',
        'canvas-to-blob.min.js' => '/lib/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js?v=4.3.7',

        'jquery.inputmask.bundle.min.js' => '/lib/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
        'fontawesome-iconpicker.min.css' => '/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css',
        'fontawesome-iconpicker.min.js' => '/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js',
        'bootstrap-duallistbox.min.css' => '/lib/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css',
        'bootstrap-duallistbox.min.js' => '/lib/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js',
        'select2.full.min.js' => '/lib/AdminLTE/plugins/select2/select2.full.min.js',
        'select2.min.css' => '/lib/AdminLTE/plugins/select2/select2.min.css',

        //编辑器
        'ckeditor.js' => '/lib/ckeditor/ckeditor.js',

        //日期
        'bootstrap-datetimepicker.min.css' =>'/lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'moment-with-locales.min.js' =>'/lib/moment/min/moment-with-locales.min.js',
        'bootstrap-datetimepicker.min.js' =>'/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',

        //数字输入
        'bootstrap-number-input.js' =>'/lib/bootstrap-number/bootstrap-number-input.js',

        //颜色
        'bootstrap-colorpicker.min.css' =>'/lib/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'bootstrap-colorpicker.min.js' =>'/lib/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.js',

        //layer
        'layer.js' =>'/lib/layer-alert/layer.js'
    ];

    /**
     * @return $this
     */
    public function createFormBuilder()
    {
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getResource($name)
    {
        return array_get($this->resource, $name);
    }


    /**
     * 展示数据
     * @param $data
     * @return \Illuminate\Support\HtmlString
     */
    public function display($data)
    {
        if($data) {
           return $this->html->tag('div', e($data), ['class' => 'box box-body  box-solid box-default no-margin']);
        }
    }

    /**
     * Create a multipleSelect box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string|bool $selected
     * @param  array  $selectAttributes
     * @param  array  $optionsAttributes
     * @param  array  $optgroupsAttributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function multipleSelect(
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }
    /**
     * Create a select2 box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string|bool $selected
     * @param  array  $selectAttributes
     * @param  array  $optionsAttributes
     * @param  array  $optgroupsAttributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function select2(
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

        $placeholder = isset($selectAttributes['placeholder']) ? $selectAttributes['placeholder'] : '请选择';
        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true,
                placeholder : "$placeholder",
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(['data-placeholder'=>"请输入",'placeholder'=>'请输入'], $selectAttributes);
        return self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }

    /**
     * select2 搜索关键字
     *
     * @param  string $url
     * @param  string $name
     * @param  array  $list
     * @param  string|bool $selected
     * @param  array  $selectAttributes
     * @param  array  $select2Param [
     *      'tags' true:是包含自己, false:不包含自己
     * ]
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function select2BySearch(
        $url,
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $select2Param = []
    ) {

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

        $tags = array_get($select2Param, 'tags', 'false');

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true,
                tags: $tags,
                allowClear: true,
                placeholder : '请输入客户名称',
                language: {
                    noResults: function () {
                        return "暂无符合搜索条件的信息";
                    },
                    searching : function () {
                        return "查询中...";
                    },
                    inputTooShort : function(a) {
                        var b = a.minimum - a.input.length,c="请至少输入"+b+"个关键字";
                        return c
                    }
                },
                ajax: {
                    url: "$url",
                    type: 'POST',
                    dataType: 'json',
                    data: function (params) {
                        return {
                             "_token": $('meta[name="csrf-token"]').attr('content'),
                            "keyword": params.term

                        };
                    },
                    processResults: function (result, params) {
                        return {
                            results: result.data.items
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(['data-placeholder'=>"请输入",'placeholder'=>'请输入'], $selectAttributes);
        return self::select($name ,$list, $selected, $selectAttributes);
    }

    /**
     * Create a dualListBox field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string|bool $selected
     * @param  array  $selectAttributes
     * @param  array  $optionsAttributes
     * @param  array  $optgroupsAttributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function dualListBox(
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.js'));

        $code = <<<EOT

            $("select[name='$name']").bootstrapDualListbox({
                "filterTextClear":"显示全部",
                "filterPlaceHolder":"过滤",
                "infoText" : "总共 {0} 项",
                "infoTextFiltered" : '{0} / {1}',
                "infoTextEmpty": "空列表",
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);

        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);

        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }

    /**
     * Create a icon input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function icon($name, $value = null, $options = [])
    {

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.js'));

        $code = <<<EOT
           $("input[name=$name]").iconpicker({placement:'bottomLeft'});\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return $this->html->tag('span', '', ['class' => 'input-group-addon'])
               . self::text($name, $value ?:'fa-bars', $options);
    }

    /**
     * 创建一个货币text
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function currency($name, $value = null, $options = [])
    {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('jquery.inputmask.bundle.min.js'));

        $code = <<<EOT
           $("input[name=$name]").inputmask({
               "alias":"currency",
               "autoGroup": !0,
               "placeholder": "0",
               "prefix":"",
               "removeMaskOnSubmit":true

           });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return $this->html->tag('span', '￥', ['class' => 'input-group-addon'])
        . self::text($name, $value , $options);
    }

    /**
     * 创建一个上传单个文件
     * @param $name
     * @param null $value
     * @param array $options
     * @return string
     */
    public function imageOne($name, $value = null, $options = [])
    {
        $path = $value ? get_file_img($value) : $value;
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('layer.js'));
        $route = get_file_img('');
        $content = route('m.system.upload.show', ['ext' => '','size'=>'300mb']);
        $style = $value ? '' :  'display: none';
        $code = <<<EOT

            $('#$name').click(function(){
            layer.open({
              type: 2,
              title: '上传文件',
              maxmin: true,
              area: ['500px', '450px'],
              content: '$content',
              btn:['保存', '关闭'],
              yes:function(index, layero) {
                var file = $(layero).find("iframe")[0].contentWindow.getFile();
                if(file) {
                  $('input[name=$name]').val(file.path);
                  $('#mig_$name').find('img').attr("src",'$route'+file.path).show();
                  $('#mig_$name').find('a').attr("href",'$route'+file.path);
                  layer.close(index);
                } else {
                  swal('请上传图片', '', 'error');
                }

              }
            });
          });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);

        $html = <<<EOT
            <span id="mig_$name" >
            <a target="_blank" href="$path">
                <img src="$path" width="300" height="173" style="float:left; $style" >
            </a>
			</span>
            <a style="margin-left: 10px" id="$name" href="javascript:;" class="btn btn-default btn-xs">上传图片</a>\n
EOT;

        return self::hidden($name, $value).$html;
    }

    public function multiImage($name, $value = null, $options = []) {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('layer.js'));
        $route = get_file_img('');
        $content = route('m.system.upload.show', ['ext' => '','size'=>'300mb']);

        $isAdd =  $value ? true : false;
        $code = <<<EOT
                    function {$name}DeleteDetails(obj) {
                            $(obj).parent().parent().remove();
                        }

                        /**
                         * 添加发票明细
                         */
                        function {$name}AddDetails (boole) {
                            if (boole != true) {
                                $('#{$name}_contents').append($("#{$name}_contents_clone .{$name}_clone").clone());
                            }

                        }

                        function {$name}MultiImageUpload (obj) {

                            layer.open({
                                type: 2,
                                title: '上传文件',
                                maxmin: true,
                                area: ['500px', '450px'],
                                content: '$content',
                                btn:['保存', '关闭'],
                                yes:function(index, layero) {
                                    var file = $(layero).find("iframe")[0].contentWindow.getFile();
                                    if(file) {
                                        $(obj).next().val(file.path);
                                        $(obj).prev().find('img').attr("src",'$route'+file.path).show();
                                        $(obj).prev().find('a').attr("href",'$route'+file.path);
                                        layer.close(index);
                                    } else {
                                        swal('请上传图片', '', 'error');
                                    }

                                }
                            });
                        }

                        $(function() {
                            {$name}AddDetails({$isAdd})
                        })
\n
EOT;

        Admin::style()->setJs(StyleTypeConst::JS_CODE_FUNCTION, $code);
        $thead = '';
        $tbody = '';
        $extend = [
            ["name" => "aaa", "title" => "张","attribute"=>"textarea"],
            ["name" => "aaa2", "title" => "张2","attribute"=>"textarea"]
        ];

        foreach ($extend as $item) {
            $thead .= "<th>{$item['title']}</th>";

            $extendFrom = call_user_func_array(
                [$this, $item["attribute"]],
                [$name."[{$item['name']}][]",'', $options]
            );

            $tbody .= "<td>$extendFrom</td>";
        }

        $html = <<<EOT
                       <table>
                            <tfoot id="{$name}_contents_clone" style="display: none">
                            <tr class="{$name}_clone">
                                <td>
                                    <span class="mig_multiImage" >
                                    <a target="_blank" class="multiImage_a" href="">
                                        <img class="multiImage_img" src="" max-width="300" max-height="173" style="float:left; display: none;"  >
                                    </a>
                                    </span>
                                    <a style="margin-left: 10px" onclick="{$name}MultiImageUpload(this)" href="javascript:;" class="btn btn-default btn-xs">上传图片</a>
                                    <input name="multiImage[img][]" class="multiImage_input" type="hidden" value="">
                                </td>
                                {$tbody}
                                <td style="text-align: center;">
                                    <button type="button" onclick="{$name}DeleteDetails(this) " class="btn btn-default btn-xs">-</button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
EOT;
        Admin::style()->setJs(StyleTypeConst::HTML, $html);

        $valueHtml = '';
        foreach ($value as $item) {
            $valueTbody = '';
            foreach ($extend as $n) {

                $extendFrom = call_user_func_array(
                    [$this, $n["attribute"]],
                    [$name."[{$n['name']}][]",$item[$n['name']], $options]
                );
                $valueTbody .= "<td>$extendFrom</td>";
            }

            $style = $item['img'] ? '' :  'display: none';
            $path = $value ? get_file_img($item['img']) : $value;
            $valueHtml .= <<<EOT
                <tr class="{$name}_clone">
                    <td>
                        <span class="mig_multiImage" >
                        <a target="_blank" class="multiImage_a" href="{$path}">
                            <img class="multiImage_img" src="{$path}" max-width="300" max-height="173" style="float:left; $style" >
                        </a>
                        </span>
                        <a style="margin-left: 10px" onclick="{$name}MultiImageUpload(this)" href="javascript:;" class="btn btn-default btn-xs">上传图片</a>
                        <input name="multiImage[img][]" class="multiImage_input" type="hidden" value="{$item['img']}">
                    </td>
                    {$valueTbody}
                    <td style="text-align: center;">
                        <button type="button" onclick="{$name}DeleteDetails(this) " class="btn btn-default btn-xs">-</button>
                    </td>
                </tr>
EOT;

        }
        $data = <<<EOT
                        <button type="button" onclick="{$name}AddDetails()" class="btn btn-default" >添加</button>
                        <table class="table table-bordered">
                          <thead>
                                <tr>
                                    <th>上传图片</th>
                                    {$thead}
                                    <th>删除</th>
                                </tr>
                            </thead>
                            <tbody id="{$name}_contents">
                            {$valueHtml}
                            </tbody >
                        </table>

                     
EOT;
        return $data;
    }

    /**
     * 开关
     * @param $name
     * @param int $value
     * @return string
     */
    public function switchOff($name, $value = WhetherConst::NO)
    {
        $options['id'] = $name;
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.js'));
        $code = <<<EOT
           $(".$name .switch").bootstrapSwitch({
                size:'small',
                onText: 'YES',
                offText: 'NO',
                onColor: 'primary',
                offColor: 'default',
                onSwitchChange: function(event, state) {
                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '2').change();
                }
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $checked = $value == WhetherConst::YES ? 'checked' : '';
        return self::checkbox('', '', '',  ['class' => 'switch la_checkbox', $checked]).self::hidden($name, $value);
    }

    /**
     * 迷你编辑器
     * @param $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function ckeditorMini($name, $value = null, $options = [])
    {
        $options['id'] = $name;
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('ckeditor.js'));
        $code = <<<EOT
           CKEDITOR.replace('$name',
            {
                toolbar : [
                    //加粗     斜体，     下划线      穿过线      下标字        上标字
                    ['Bold','Italic','Underline','Strike','Subscript','Superscript'],
                    //数字列表          实体列表            减小缩进    增大缩进
                    ['NumberedList','BulletedList','-','Outdent','Indent'],
                    //左对齐             居中对齐          右对齐          两端对齐
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                    //超链接 取消超链接 锚点
                    ['Link','Unlink','Anchor'],
                     //文本颜色     背景颜色
                    ['TextColor','BGColor'],
                    //全屏           显示区块
                    ['Maximize', 'ShowBlocks','-'],
                    '/',
                    //图片     表格       水平线            表情       特殊字符        分页符
                    ['Image','Html5video','Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
                      //样式       格式      字体    字体大小
                    ['Styles','Format','Font','FontSize'],
                ]
            }
        );\n
EOT;

        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::textarea($name, $value = null, $options = []);
    }

    /**
     * 编辑器
     * @param $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function ckeditor($name, $value = null, $options = [])
    {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('ckeditor.js'));
        $code = <<<EOT
           CKEDITOR.replace('$name');
EOT;

        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::textarea($name, $value, $options = []);
    }

    /**
     * 日期
     * @param string $name
     * @param null $value
     * @param array $options
     * @param string $format
     * @return \Illuminate\Support\HtmlString
     */
    public function datetime($name, $value = null, $options = [], $format = 'YYYY-MM-DD HH:mm:ss')
    {
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('moment-with-locales.min.js'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.js'));
        $code = <<<EOT
 $('input[name={$name}]').datetimepicker({"format":"{$format}","locale":"zh-CN","allowInputToggle":true});
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::text($name, $value , $options);
    }

    /**
     * 日期范围
     * @param $start
     * @param $end
     * @param array $options
     * @param string $format
     * @return string
     */
    public function datetimeRange($start, $end , $options = [], $format = 'YYYY-MM-DD HH:mm:ss')
    {
        $options['style'] = 'width: 50%;';
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('moment-with-locales.min.js'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.js'));
        $code = <<<EOT
            $('input[name={$start['name']}]').datetimepicker({"format":"{$format}","locale":"zh-CN"});
            $('input[name={$end['name']}]').datetimepicker({"format":"{$format}","locale":"zh-CN","useCurrent":false});

            $('input[name={$start['name']}]').on("dp.change", function (e) {
                $('input[name={$end['name']}]').data("DateTimePicker").minDate(e.date);
            });
            $("input[name={$end['name']}]").on("dp.change", function (e) {
                $('input[name={$start['name']}]').data("DateTimePicker").maxDate(e.date);
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::text($start['name'], $end['value'] , $options).
        self::text($end['name'], $end['value'] , $options);
    }

    /**
     * 数字
     * @param string $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function number($name, $value = null, $options = [])
    {
        if(!isset($options['min'])) {
            $options['min'] = 0;
        }
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-number-input.js'));
        $code = <<<EOT
            $('input[name={$name}]')
            .addClass('initialized')
            .bootstrapNumber({
                upClass: 'success',
                downClass: 'primary',
                center: true
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return  self::text($name, $value , $options);
    }

    public function color($name, $value = null, $options = [])
    {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-colorpicker.min.js'));
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-colorpicker.min.css'));
        $code = <<<EOT

            $('input[name={$name}]').parent().colorpicker({
            'format' :'hex'
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);


          return  '<span class="input-group-addon"><i></i></span>'.self::text($name, $value , $options);
    }
}
