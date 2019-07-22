<?php

namespace App\Admin\Bls\Client\Requests;

use App\Library\Validators\JsonResponseValidator;


class NewsRequests extends JsonResponseValidator
{

    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
        ];
    }


}