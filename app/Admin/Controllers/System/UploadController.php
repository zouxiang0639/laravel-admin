<?php

namespace App\Admin\Controllers\System;

use App\Library\Admin\Upload\UploadStrategy;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Admin;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $file = $request->file('file');

        $data = Admin::upload()->uploadOneImage($file);
        return (new JsonResponse())->success($data);
    }

    public function ckeditor(Request $request)
    {
        $file = $request->file('upload');

        $data = Admin::upload()->uploadOneImage($file);
        $data = [
            'uploaded' => 1,
            'fileName' =>$data['url'],
            'url' => $data['url']
        ];
        return json_encode($data);
    }

    public function show(Request $request)
    {
        //上传的格式
        $ext = $request->ext;
        if(is_null($ext)) {
            $ext = 'jpeg,jpg,png';
        }

        $upload = (new UploadStrategy(config("upload.upload_drive")))->get();
        //限制上传文件大小  默认php.ini post_max_size
        $size = empty($request->size) ? '' : $request->size;

        return view('admin::system.upload.'.$upload['show'], array_merge([
            'ext' => $ext,
            'size' => $size
        ],$upload));
    }
}
