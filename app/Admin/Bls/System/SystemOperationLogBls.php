<?php

namespace App\Admin\Bls\System;

use App\Admin\Bls\Auth\AdminUserBls;
use App\Bls\Admin\UserBls;
use App\Admin\Bls\System\Model\SystemOperationLogModel;

class SystemOperationLogBls
{
    public static function store($businessNo, $functionBlock, $action)
    {
        $model = new SystemOperationLogModel();
        $model->business_no = $businessNo;
        $model->operator = \Auth::guard('admin')->id();


        $model->url = \URL::full();
        $model->ip = \Request::getClientIp();
        $model->function_block = $functionBlock;
        $model->action = $action;
        $model->save();
    }

    public static function lists($request, $limit = 20)
    {

        $model = SystemOperationLogModel::query();
        if (!empty($request->operator)) {
            $user = AdminUserBls::getDataByOnlyName($request->operator);
            $userId = is_null($user) ? 0 : $user->id;
            $model->where('operator', $userId);
        }
        return $model->orderBy('id', 'desc')->paginate($limit);
    }
}
