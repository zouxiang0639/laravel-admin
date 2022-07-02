<?php
namespace App\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Web\Bls\Util\PageUtil;

class HomeController extends Controller
{
    public function index()
    {
        $seo = PageUtil::getSeo();
        return view('web::home.index',[
            "seo" => $seo
        ]);
    }
}
