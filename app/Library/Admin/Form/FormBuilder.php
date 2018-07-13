<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Library\Admin\Consts\StyleTypeConst;

class FormBuilder extends \Collective\Html\FormBuilder
{

    public function createFormBuilder()
    {
        return $this;
    }

    /**
     * 展示数据
     * @param string $data
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

        Admin::setCss(StyleTypeConst::FILE, '/lib/AdminLTE/plugins/select2/select2.min.css');
        Admin::setJs(StyleTypeConst::FILE, '/lib/AdminLTE/plugins/select2/select2.full.min.js');

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
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

        Admin::setCss(StyleTypeConst::FILE, '/lib/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css');
        Admin::setJs(StyleTypeConst::FILE, '/lib/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js');

        $code = <<<EOT

            $("select[name='$name']").bootstrapDualListbox({
                "filterTextClear":"显示全部",
                "filterPlaceHolder":"过滤",
                "infoText" : "总共 {0} 项",
                "infoTextFiltered" : '{0} / {1}',
                "infoTextEmpty": "空列表",
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);

        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }
}
