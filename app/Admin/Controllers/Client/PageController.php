<?php


namespace App\Admin\Controllers\Client;

use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\PageRequests;
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
class PageController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if($request->template == null) {
            $request->merge(['template' => PageTemplateConst::PAGE]);
        }
        $list = PageBls::getList($request);

        $list->getCollection()->each(function($item) {
            $item->templateName = PageTemplateConst::getDesc($item->template);
            $item->route = PageBls::getSubsetRoute($item->template);
        });

        return View::make('admin::client.page.index',[
            'list' => $list,
            'type' => PageTemplateConst::desc(true)
        ]);
    }


    /**
     * 创建
     * @param Request $request
     * @return mixed
     * @throws LogicException
     */
    public function create(Request $request)
    {

        if(empty($request->template) || !PageTemplateConst::getDesc($request->template)) {
            throw new LogicException(1010005);
        }

        return View::make('admin::client.page.create',[
        ]);
    }

    /**
     * 存储
     * @param PageRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(PageRequests $request)
    {
        if(PageBls::store($request)) {
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
        $model = PageBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::client.page.edit',[
            'info' =>  $model
        ]);
    }

    /**
     * @param AdvertRequests $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(PageRequests $request, $id)
    {
        $model = PageBls::find($id);

        $this->isEmpty($model);

        if(PageBls::update($model, $request)) {
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
        $model = PageBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

}
