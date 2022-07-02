<?php

namespace App\Admin\Bls\Client;
use App\Admin\Bls\Client\Model\PageModel;
use App\Admin\Bls\Client\Requests\PageRequests;
use App\Consts\Admin\Client\PageTemplateConst;
use Illuminate\Http\Request;

/**
 * Class RoleBls.
 */
class PageBls
{

    public static function getList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = PageModel::query();

        if(!empty($request->template)) {
            $model->where('template', $request->template);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function store(PageRequests $request)
    {
        $model = new PageModel();
        $model->title = $request->title;
        $model->template = $request->template;
        $model->picture = $request->picture ?: '';
        $model->comment = $request->comment ?: '';
        $model->contents = $request->contents ?: '';
        $model->extend = $request->extend ?: [];
        $model->keywords = $request->keywords ?: '';
        $model->description = $request->description ?: '';
        return $model->save();
    }

    public static function find($id)
    {
        return PageModel::find($id);
    }

    public static function update(PageModel $model,PageRequests $request)
    {
        $model->title = $request->title;
        $model->template = $request->template;
        $model->picture = $request->picture ?: '';
        $model->comment = $request->comment ?: '';
        $model->contents = $request->contents ?: '';
        $model->extend = $request->extend ?: [];
        $model->keywords = $request->keywords ?: '';
        $model->description = $request->description ?: '';
        return $model->save();

    }

    public static function getPageAll()
    {
        return PageModel::all();
    }

    public static function getPageBySeo($model)
    {
        $config = config('config');

        return [
            'title' => $config['title'] . '-' . $model->title,
            'keywords' => empty($model->keywords) ? $config['keywords'] : $model->keywords,
            'description' => empty($model->description) ? $config['description'] : $model->description,
        ];
    }
}

