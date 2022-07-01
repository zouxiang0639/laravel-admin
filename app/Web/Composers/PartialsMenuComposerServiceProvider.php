<?php
namespace App\Web\Composers;

use App\Admin\Bls\System\ConfigBls;
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
        $config = ConfigBls::getConfig();

        $view->with('title', $config['title'])
        ->with('keywords', $config['keywords'])
        ->with('ico', $config['ico'])
        ->with('description', $config['description']);
    }
}
