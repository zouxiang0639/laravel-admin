<?php

namespace App\Admin\Bls\Client;

use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Client\Model\NavModel;
use App\Admin\Bls\Client\Requests\NavRequests;
use App\Consts\Admin\Client\NavBindTypeConst;
use App\Library\Admin\Widgets\Tree;
use Admin;

/**
 * Class RoleBls.
 */
class NavBls
{
    /**
     * @var int
     */
    static $branchOrder = 1;

    /**
     * @return Tree
     */
    public static function treeView($request)
    {

        return Admin::tree(new NavModel(), function (Tree $tree) use ($request) {
            $tree->setDate(function(NavModel $query) use ($request) {
                return $query->where('category',$request->category)->orderBy('order', 'asc');
            })->toArray();

            $tree->formatDate(function($item){
                $item['route'] = '';
                if($item['bind_type'] == NavBindTypeConst::BIND_PAGE) {
                    $page = PageBls::find($item['page_id']);
                    if(!is_null($page)) {
                        if(empty($item['title'])) {
                            $item['title'] = $page->title;
                        }
                        $item['route'] =  PageBls::getSubsetRoute($page->template);
                    }
                }
                return $item;
            })->setItems();

            $tree->setView([
                'tree'   => 'admin::client.nav.tree.menu',
                'branch' => 'admin::client.nav.tree.menu_branch',
            ]);
            $tree->path = route('m.client.nav.sort');

            $tree->disableCreate();

            $tree->branch(function ($branch) {

                $payload = "&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
            });
        });
    }

    /**
     * 存储菜单数据
     * @param NavRequests $request
     * @return mixed
     */
    public static function store(NavRequests $request)
    {
        $model = new NavModel();
        $model->parent_id = $request->parent_id;
        $model->title = $request->title ?: '';
        $model->bind_type = $request->bind_type;
        $model->category = $request->category;
        $model->page_id = $request->page_id  ?: '';
        $model->url = $request->url ?: '';
        return $model->save();
    }

    /**
     * 更新菜单数据
     * @param NavRequests $request
     * @param NavModel $model
     * @return mixed
     */
    public static function update(NavRequests $request, NavModel $model)
    {
        $model->parent_id = $request->parent_id;
        $model->title = $request->title ?: '';
        $model->bind_type = $request->bind_type;
        $model->page_id = $request->page_id  ?: '';
        $model->url = $request->url ?: '';

        return $model->save();
    }

    /**
     * 获取菜单select数据
     * @param $type
     * @return array
     */
    public static function selectOptions($type)
    {

        $array =  Admin::tree(new NavModel(), function (Tree $tree) use($type) {
            $tree->setDate(function (NavModel $query) use($type) {
                return $query->where('category', $type)->orderBy('order', 'asc');
            })->toArray()->setItems(Tree::BUILD_SELECT_OPTIONS);
        })->getItems();
        return collect($array)->prepend('/', 0)->all();
    }


    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return NavModel::find($id);

    }


    public static function sort($sort)
    {
        $tree = json_decode($sort, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        static::saveOrder($tree);
        return true;
    }

    /**
     * Save tree order from a tree like array.
     *
     * @param array $tree
     * @param int   $parentId
     */
    public static function saveOrder($tree = [], $parentId = 0)
    {


        foreach ($tree as $branch) {
            $model = static::find($branch['id']);
            $model->parent_id = $parentId;
            $model->order = static::$branchOrder ++;

            $model->save();

            if (isset($branch['children'])) {
                static::saveOrder($branch['children'], $branch['id']);
            }
        }
    }

    /**
     * 获取menu树数据
     * @return mixed
     */
    public static function menuTree()
    {

       return Admin::tree(new NavModel(), function (Tree $tree) {
            $tree->setDate(function (NavModel $query) {
                return $query->orderBy('order', 'asc');
            })->toArray()->setItems();
        })->getItems();
    }

    public static function checkNav($pageId)
    {
        return NavModel::where('page_id', $pageId)->count();
    }

}

