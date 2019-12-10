<?php
namespace App\Library\Admin\Log;


use App\Admin\Bls\System\SystemOperationLogBls;

class SystemLogBuilder
{

    protected $route = [];


    public function make($request, $name)
    {

        if(isset($this->route[$name])) {
            $param = $this->route[$name];
            $businessNo = '';
            $functionBlock = '';
            $action = '';

            if($param['multipleRules'] == true) {
                foreach($param['rules'] as $item) {
                    list($key, $value) = $item['regulation'];
                    if($request->$key == $value) {
                        $businessNoKey = $item['business_no'];
                        $businessNo = empty($item['business_no']) ? 0 : $request->$businessNoKey;
                        $functionBlock = $item['function_block'];
                        $action = $item['action'];
                    }
                }

            } else {
                $businessNoKey = $param['business_no'];
                $businessNo = empty($param['business_no']) ? 0 : $request->$businessNoKey;
                $functionBlock = $param['function_block'];
                $action = $param['action'];
            }
            if(empty($functionBlock)) {
                return true;
            }
            SystemOperationLogBls::store($businessNo, $functionBlock, $action);
        }
    }

    public function setRoute($route, $data, $multipleRules = false)
    {
        if($multipleRules == false) {
            $this->route[$route] = $data;
        } else {
            $this->route[$route]['rules'] = $data;
        }

        $this->route[$route]['multipleRules'] = $multipleRules;
        return $this;
    }
}
