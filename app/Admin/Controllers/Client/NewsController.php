<?php


namespace App\Admin\Controllers\Client;

use App\Admin\Bls\Client\NewsBls;
use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\NewsRequests;
use App\Admin\Bls\Client\Requests\PageRequests;
use App\Admin\Bls\Other\Requests\AdvertRequests;
use App\Consts\Admin\Client\PageTemplateConst;
use App\Consts\Common\WhetherConst;
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
class NewsController extends Controller
{
    public $template = PageTemplateConst::NEWS;
    public $page = '';

    public function __construct(Request $request)
    {
        $page = PageBls::find($request->cid);

        if(is_null($page) || $page->template != $this->template) {
            throw new LogicException(1010003, '数据查询失败');
        }
        $this->page = $page;
    }

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws LogicException
     */
    public function index(Request $request)
    {

        $list = NewsBls::getList($request);

        $list->getCollection()->each(function($item) {

        });

        return View::make('admin::client.news.index',[
            'list' => $list,
            'page' => $this->page
        ]);
    }


    /**
     * 创建
     * @return mixed
     * @throws LogicException
     */
    public function create()
    {

        return View::make('admin::client.news.create',[
            'page' => $this->page
        ]);
    }

    /**
     * 存储
     * @param NewsRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(NewsRequests $request)
    {
        if(NewsBls::store($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }


    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $model = NewsBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::client.news.edit',[
            'info' =>  $model,
            'page' => $this->page
        ]);
    }

    /**
     * @param AdvertRequests $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(NewsRequests $request, $id)
    {
        $model = NewsBls::find($id);

        $this->isEmpty($model);

        if(NewsBls::update($model, $request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = NewsBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 更新状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = NewsBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }

    /**
     * 更新排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function order(Request $request)
    {

        $model = NewsBls::find($request->pk);

        $model->order = intval($request->value);

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }

}
