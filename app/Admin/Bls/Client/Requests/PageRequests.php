<?php

namespace App\Admin\Bls\Client\Requests;

use App\Library\Validators\JsonResponseValidator;


class PageRequests extends JsonResponseValidator
{

    public function rules()
    {
        return [
            'title' => 'required',
            'template' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'template.required' => '模版不能为空',
        ];
    }


}