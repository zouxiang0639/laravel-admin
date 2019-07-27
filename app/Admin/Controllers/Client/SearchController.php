<?php


namespace App\Admin\Controllers\Client;

use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\PageRequests;
use App\Admin\Bls\Client\SearchBls;
use App\Admin\Bls\Other\Requests\AdvertRequests;
use App\Consts\Admin\Client\PageTemplateConst;
use App\Exceptions\LogicException;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

/**
 * Created by AdvertController.
 * @author: zouxiang
 * @date:
 */
class SearchController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $list = SearchBls::getList($request);

        return View::make('admin::client.search.index',[
            'list' => $list,
        ]);
    }


    public function generate()
    {
        if(SearchBls::store()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

}
