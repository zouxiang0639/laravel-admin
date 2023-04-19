<?php

namespace App\Admin\Controllers\System;

use App\Admin\Bls\System\SystemOperationLogBls;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class OperationLogController  extends Controller
{
    public function index(Request $request)
    {
        $list = SystemOperationLogBls::lists($request);


        $list->getCollection()->each(function($item) {
            $item->operatorName = '-';
            if($item->operators) {
                $item->operatorName = $item->operators->name;
            }
        });

        return view('admin::system.operationLog.index', [
            'list' => $list
        ]);
    }



}
