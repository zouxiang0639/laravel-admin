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
            'url' => 'required_if:url,'. NavBindTypeConst::BIND_URL,
        ];
    }

    public function messages()
    {
        return [
            'page_id.required' => '页面不能为空',
            'url.required' => 'URL不能为空',
        ];
    }


}