<?php
namespace App\Web\Controllers;

use App\Admin\Bls\Client\NewsBls;
use App\Consts\Admin\Client\PageTemplateConst;
use App\Http\Controllers\Controller;
use App\Web\Bls\Util\PageUtil;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page($id)
    {
        $data = PageUtil::getPage($id);
        if ($data["info"]["template"] != PageTemplateConst::PAGE) {
            abort(404);
        }
        return view('web::page.page', $data);
    }

    public function news($id,Request $request)
    {
        $data = PageUtil::getPage($id);
        if ($data["info"]["template"] != PageTemplateConst::NEWS) {
            abort(404);
        }
        $list = PageUtil::getList(NewsBls::class,$data["info"]["id"],$request,'`id` DESC', 10);
        $data['newsList'] = $list;

        return view('web::page.news', $data);
    }


    public function newsInfo($id)
    {

        $data = PageUtil::getListInfo(NewsBls::class,$id);

        return view('web::page.news', $data);
    }
}
