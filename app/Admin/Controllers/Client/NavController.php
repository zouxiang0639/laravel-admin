<?php

namespace App\Admin\Controllers\Client;

use App\Admin\Bls\Auth\MenuBls;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\NavRequests;
use App\Consts\Admin\Client\NavBindTypeConst;
use App\Consts\Admin\Client\NavCategoryConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Response\JsonResponse;
use App\Library\Admin\Form\FormBuilder;
use Admin;
use Illuminate\Http\Request;
use View;

class NavController extends Controller
{

    /**
     * 列表 and 创建
     * @return View
     */
    public function index(Request $request)
    {
        dd(NavBls::getNavCrumbs(8));
        if(empty($request->category)) {
            $request->merge([
                'category' => NavCategoryConst::HEADER
            ]);
        }

        $list = NavBls::treeView($request);

        return View::make('admin::client.nav.index',[
            'list' => $list,
            'form' =>  $this->form(['category' => $request->category]),
        ]);
    }

    /**
     * 存储
     * @param NavRequests $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(NavRequests $request)
    {

        if(NavBls::store($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\View
     * @throws LogicException
     */
    public function edit($id)
    {
        $model = NavBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::client.nav.edit',[
            'form' =>  $this->form($model),
            'info' =>  $model
        ]);
    }

    /**
     * 更新
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(NavRequests $request, $id)
    {
        $model = NavBls::find($id);

        $this->isEmpty($model);
        if($model->id == $request->parent_id)
        {
            throw new LogicException(1010001, ['parent_id'=>['父级菜单不能为自己']]);
        }

        if(NavBls::update($request, $model)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 销毁
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {

        $model = NavBls::find($id);

        $this->isEmpty($model);

        if(!$model->children->isEmpty()) {
            throw new LogicException(1010002, '请删除子菜单后才可以删除');
        }

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    public function sort(Request $request)
    {
        if(NavBls::sort($request->_order)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }


    /**
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function($item) use ($info)  {

            $item->create('父级菜单', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->Select2('parent_id',  NavBls::selectOptions($info['category']), array_get($info, 'parent_id'), $h->options);
                $h->set('parent_id', true);
            });

            $item->create('标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->input .= $form->hidden('category', array_get($info, 'category'), $h->options);
                $h->set('title', false);
            });

            $item->create('绑定类型', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->select('bind_type', NavBindTypeConst::desc(), array_get($info, 'bind_type'), $h->options);
                $h->set('bind_type', true);
            });

            $item->create('页面', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $page = PageBls::getPageAll();
                $h->input = $form->select2('page_id', $page->pluck('title','id'), array_get($info, 'page_id'), $h->options);
                $h->set('parent_id', true);
                $h->id = 'page_html';
                $h->helpBlock = '绑定本网站页面,';
            });

            $item->create('URL', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('url', array_get($info, 'url'), $h->options);
                $h->set('url', true);
                $h->id = 'url_html';
                $h->helpBlock = '绑定URL  会跳转到URL对应的页面';
            });


            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });

            $item->create('更新时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'updated_at'));
            });

        })->getFormHtml();
    }


}
