<?php
namespace App\Http\Composers\Admin;

use Illuminate\Http\Request;

/**
 * 测试数据
 */
class HeaderComposer
{
	private $user;

	public function __construct(Request $request)
	{
		$this->user = $request->user();
	}


    public function compose($view)
    {
        $homeLink = route('admin.home');

        $view->with('siteName', '测试数据')->with('homeLink', $homeLink);
    }
}
