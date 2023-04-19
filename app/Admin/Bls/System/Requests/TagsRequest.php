<?php

namespace App\Admin\Bls\System\Requests;

use App\Consts\Admin\Tags\TagsTypeConst;
use App\Library\Validators\JsonResponseValidator;

class TagsRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        \Validator::extendImplicit('checkParentId', function ($attribute, $value, $parameters) {
            if(end($parameters) >= 1 && empty($value)) {
                return false;
            } else {
                return true;
            }
        });
        return [
            'type' => 'required',
            'parent_id' => 'checkParentId:'.TagsTypeConst::getParent($this->type),
            'tag_name' => 'required|unique:admin_tags,tag_name,' . $this->id . ',id,type,' .$this->type,
            'status' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.required' => '标签类型不能为空',
            'tag_name.required' => '标签名称不能为空',
            'tag_name.unique' => '标签名称已存在',
            'status.required' => '标签状态不能为空',
            'parent_id.check_parent_id' => '请选择父级',
        ];
    }


}
