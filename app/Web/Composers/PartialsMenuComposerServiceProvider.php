<?php
namespace App\Web\Composers;

use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\System\ConfigBls;
use App\Consts\Admin\Client\NavCategoryConst;
use Illuminate\Http\Request;

/**
 * 样式 菜单
 */
class PartialsMenuComposerServiceProvider
{


	public function __construct(Request $request)
	{

	}


    public function compose($view)
    {
        $menu = NavBls::menuTree(NavCategoryConst::HEADER);
        $view->with('menu', $menu);
    }
}
