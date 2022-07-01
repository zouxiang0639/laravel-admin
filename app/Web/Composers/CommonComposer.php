<?php
namespace App\Web\Composers;

use Illuminate\Http\Request;

/**
 * 测试数据
 */
class CommonComposer
{


	public function __construct(Request $request)
	{

	}


    public function compose($view)
    {

        $view->with('title', '测试数据');
    }
}
