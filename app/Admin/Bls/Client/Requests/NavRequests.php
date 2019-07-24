<?php

namespace App\Admin\Bls\Client\Requests;

use App\Consts\Admin\Client\NavBindTypeConst;
use App\Library\Validators\JsonResponseValidator;


class NavRequests extends JsonResponseValidator
{

    public function rules()
    {

        return [
            'page_id' => 'required_if:bind_type,'. NavBindTypeConst::BIND_PAGE,
            'url' => 'required_if:bind_type,'. NavBindTypeConst::BIND_URL,
            'title' => 'required_if:bind_type,' . NavBindTypeConst::JUMP . ','. NavBindTypeConst::BIND_URL,
        ];
    }

    public function messages()
    {
        return [
            'page_id.required_if' => '页面不能为空',
            'url.required_if' => 'URL不能为空',
            'title.required_if' => '标题不能为空',
        ];
    }


}