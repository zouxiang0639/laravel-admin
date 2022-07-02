<?php

namespace App\Web\Bls\Util;

use App\Admin\Bls\Client\Model\PageModel;
use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\Client\PageBls;
use App\Admin\Bls\Client\Requests\PageRequests;
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
}

