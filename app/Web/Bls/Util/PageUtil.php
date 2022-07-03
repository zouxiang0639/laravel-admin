<?php

namespace App\Web\Bls\Util;

use App\Admin\Bls\Client\Model\PageModel;
use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\PageRequests;
use App\Consts\Admin\Client\NavCategoryConst;
use App\Consts\Admin\Client\PageTemplateConst;
use Illuminate\Http\Request;

/**
 * Class RoleBls.
 */
class PageUtil
{
    public static function getPage($id)
    {

        $nav = NavBls::find($id);
        if (empty($nav)) {
            abort(404);
        }

        $info = PageBls::find($nav['page_id']);
        if (empty($info)) {
            abort(404);
        }
        $pageTitle = $info['title'];

        if (!empty($nav['title'])) {
            $pageTitle = $nav['title'];
            $info->title = $nav['title'];
        }

        $seo = PageBls::getPageBySeo($info);
        return [
            'info' => $info,
            'seo' => $seo,
            'pageTitle' => $pageTitle
        ];
    }

    public static function getList($class, $pageId, Request $request, $order = '`id` DESC', $limit = 20)
    {
        $bls = new $class();
        $request->cid = $pageId;
        return $bls->getList($request, $order , $limit );
    }

    public static function getListInfo($class, $id)
    {
        $bls = new $class();
        $info = $bls->find($id);
        if (empty($info)) {
            abort(404);
        }

        $page = PageBls::find($info['page_id']);
        if (empty($page)) {
            abort(404);
        }

        $nav = NavBls::getNav($page->id,NavCategoryConst::HEADER);
        if (empty($nav)) {
            abort(404);
        }

        $pageTitle = $info['title'];

        if (!empty($nav['title'])) {
            $pageTitle = $nav['title'];
        }


        $seo = PageBls::getPageBySeo($info);


        return [
            'info' => $info,
            'page' => $page,
            'seo' => $seo,
            'pageTitle' => $pageTitle
        ];
    }

    public static function getSeo()
    {
        $model = new \stdClass();
        $model->title = "";
        $model->keywords = "";
        $model->description = "";
        return PageBls::getPageBySeo($model);
    }
}

