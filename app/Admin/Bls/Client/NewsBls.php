<?php

namespace App\Admin\Bls\Client;

use App\Admin\Bls\Client\Model\NewsModel;
use App\Admin\Bls\Client\Requests\NewsRequests;
use App\Consts\Common\WhetherConst;
use Illuminate\Http\Request;

/**
 * Class NewsBls.
 */
class NewsBls
{

    /**
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = NewsModel::query();

        if(!empty($request->title)) {
            $model->where('title', 'like', '%' . $request->title . '%');
        }

        if(!empty($request->cid)) {
            $model->where('page_id', $request->cid);
        }

        return $model->orderBy('order','desc')->orderByRaw($order)->paginate($limit);
    }


    /**
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getListByClient($data, $order = '`id` DESC', $limit = 20)
    {
        $model = NewsModel::query();

        if(!empty($data['cid'])) {
            $model->where('page_id', $data['cid']);
        }

        return $model->where('status', WhetherConst::YES)->orderBy('order','desc')->orderByRaw($order)->paginate($limit);
    }

    public static function store(NewsRequests $request)
    {
        $model = new NewsModel();
        $model->page_id = $request->page_id;
        $model->title = $request->title;
        $model->picture = $request->picture ?: '';
        $model->comment = $request->comment ?: '';
        $model->contents = $request->contents ?: '';
        $model->keywords = $request->keywords ?: '';
        $model->description = $request->description ?: '';
        $model->status  = WhetherConst::YES;
        return $model->save();
    }

    public static function find($id)
    {
        return NewsModel::find($id);
    }

    public static function update(NewsModel $model,NewsRequests $request)
    {
        $model->title = $request->title;
        $model->picture = $request->picture ?: '';
        $model->comment = $request->comment ?: '';
        $model->contents = $request->contents ?: '';
        $model->keywords = $request->keywords ?: '';
        $model->description = $request->description ?: '';
        return $model->save();

    }

    /**
     * 获取上一条
     * @param $id
     * @param $pageId
     * @return mixed
     */
    public static function getLast($id, $pageId)
    {

        return NewsModel::where('page_id', $pageId)->where('status', WhetherConst::YES)->where('id', '>' ,$id)->orderBy('order','desc')->orderBy('id', 'asc')->first();
    }

    public static function getNext($id, $pageId)
    {
        return NewsModel::where('page_id', $pageId)->where('status', WhetherConst::YES)->where('id', '<' ,$id)->orderBy('order','desc')->orderBy('id', 'desc')->first();
    }

    public static function getPageBySeo(NewsModel $model)
    {
        $config = config('config');
        return [
            'title' => $config['title'] . '-' . $model->title,
            'keywords' => empty($model->keywords) ? $config['keywords'] : $model->keywords,
            'description' => empty($model->description) ? $config['description'] : $model->description,
        ];
    }
}

