<?php

namespace App\Admin\Controllers\Client;

use App\Admin\Bls\Auth\MenuBls;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Client\NavBls;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Response\JsonResponse;
use App\Library\Admin\Form\FormBuilder;
use Admin;
use View;
use Request;

class NavController extends Controller
{

    /**
     * 列表 and 创建
     * @return View
     */
    public function index()
    {
        $list = NavBls::treeView();

        return View::make('admin::auth.menu.index',[
            'list' => $list,
            'form' =>  $this->form([]),
        ]);
    }

    /**
     * 存储
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(MenuRequest $request)
    {
        if(MenuBls::storeMenu($request)) {
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
        $model = MenuBls::find($id);

        $this->isEmpty($model);

        return View::make('admin::auth.menu.edit',[
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
    public function update(MenuRequest $request, $id)
    {
        $model = MenuBls::find($id);

        $this->isEmpty($model);
        if($model->id == $request->parent_id)
        {
            throw new LogicException(1010001, ['parent_id'=>['父级菜单不能为自己']]);
        }

        if(MenuBls::updateMenu($request, $model)) {
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
        $model = MenuBls::find($id);

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

    public function sort()
    {

        if(MenuBls::sort(Request::input('_order'))) {
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
                $h->input = $form->Select2('parent_id',  NavBls::selectOptions(1), array_get($info, 'parent_id'), $h->options);
                $h->set('parent_id', true);
            });

            $item->create('标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('父级菜单', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->Select2('parent_id',  NavBls::selectOptions(1), array_get($info, 'parent_id'), $h->options);
                $h->set('parent_id', true);
            });



            $item->create('模版', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('route', array_get($info, 'route'), $h->options);
                $h->set('route', false);
                $h->helpBlock = '路由只能是路由别名,http,https';
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
