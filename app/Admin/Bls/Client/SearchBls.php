<?php

namespace App\Admin\Bls\Client;

use App\Admin\Bls\Client\Model\NewsModel;
use App\Admin\Bls\Client\Model\PageModel;
use App\Admin\Bls\Client\Model\SearchModel;
use App\Consts\Admin\Client\PageTemplateConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleBls.
 */
class SearchBls
{


    public static function getList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = SearchModel::query();

        if(!empty($request->template)) {
            $model->where('template', $request->template);
        }

        if(!empty($request->title)) {
            $model->where('title', 'like', '%' . $request->title . '%');
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function store()
    {
        SearchModel::truncate();
        static::generateNews();
        static::generatePage();
        return true;
    }

    public static function generateNews()
    {

        $data = NewsModel::select(DB::raw('admin_news.id as business_no, admin_news.title, admin_page.template'))
            ->join('admin_page','admin_page.id','admin_news.page_id')->get()->each(function($item) {
                $route = PageTemplateConst::getWebRoute($item->template);
                $item->url = route($route,['id' => $item->business_no]);
            })->toArray();
        SearchModel::insert($data);
    }

    public static function generatePage()
    {
        $data = PageModel::select(DB::raw('admin_page.id as business_no, admin_page.title as page_title, admin_page.template, admin_nav.id as nav_id,  admin_nav.title'))
            ->join('admin_nav','admin_nav.page_id','admin_page.id')->groupBy('business_no')->get()
            ->each(function($item) {
                $route = PageTemplateConst::getWebRoute($item->template);
                $item->url = route($route,['id' => $item->nav_id]);
                if(empty($item->title)) {
                    $item->title = $item->page_title;
                }
                unset($item->page_title);
                unset($item->nav_id);
            })->toArray();
        SearchModel::insert($data);
    }
}

