<?php

namespace App\Library\Admin\Widgets;


use App\Library\Admin\Consts\StyleTypeConst;

class Style
{

    public $js = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => [], StyleTypeConst::JS_CODE_FUNCTION => [], StyleTypeConst::HTML => []];

    public $css = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => []];

    public function setCss($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->css[StyleTypeConst::FILE][] = '<link rel="stylesheet" href="' . assets_path($data) . '">';
                break;

            case StyleTypeConst::CODE:

                $this->css[StyleTypeConst::CODE][] = $data;
                break;

            default:
                break;
        }
    }

    public function setJs($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->js[StyleTypeConst::FILE][] = '<script src="' . assets_path($data) . '"></script>';
                break;

            case StyleTypeConst::CODE:

                $this->js[StyleTypeConst::CODE][] = $data;
                break;
            case StyleTypeConst::JS_CODE_FUNCTION:

                $this->js[StyleTypeConst::JS_CODE_FUNCTION][] = $data;
                break;
            case StyleTypeConst::HTML:
                $this->js[StyleTypeConst::HTML][] = $data;
                break;

            default:
                break;
        }
    }

    public function getCss()
    {
        $file = array_unique($this->css[StyleTypeConst::FILE]);
        $css = '';
        $code = '';
        foreach ($file as $v) {
            $css .= $v;
        }

        foreach($this->css[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }

        $css .= <<<EOT
        <style>
            $code
        </style>

EOT;
        return $css;
    }

    public function getJs()
    {
        $file = array_unique($this->js[StyleTypeConst::FILE]);
        $js = '';
        $code = '';
        $jsCodeFunction = '';
        foreach ($file as $v) {
            $js .= $v;
        }

        foreach($this->js[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }
        foreach($this->js[StyleTypeConst::JS_CODE_FUNCTION] as $v) {
            $jsCodeFunction .= $v;
        }

        $js .= <<<EOT

        <script>
        $jsCodeFunction
            $(function () {
                $code
            });
        </script>
EOT;
        return $js;
    }

    public function getHtml()
    {
        $html = '';
        foreach($this->js[StyleTypeConst::HTML] as $v) {
            $html .= $v;
        }
        return $html;
    }
}
