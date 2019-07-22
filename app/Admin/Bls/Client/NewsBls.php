<?php

namespace App\Admin\Bls\Client;

use App\Admin\Bls\Client\Model\NewsModel;
use App\Admin\Bls\Client\Requests\NewsRequests;
use Illuminate\Http\Request;

/**
 * Class NewsBls.
 */
class NewsBls
{

    public static function getList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = NewsModel::query();

        if(!empty($request->title)) {
            $model->where('title', 'like', '%' . $request->title . '%');
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function store(NewsRequests $request)
    {
        $model = new NewsModel();
        $model->title = $request->title;
        $model->picture = $request->picture ?: '';
        $model->comment = $request->comment ?: '';
        $model->contents = $request->contents ?: '';
        $model->keywords = $request->keywords ?: '';
        $model->description = $request->description ?: '';
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
}

