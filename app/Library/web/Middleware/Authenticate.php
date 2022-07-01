<?php

namespace App\Library\web\Middleware;

use App\Consts\Admin\Role\RoleSlugConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;

/**
 * Created by Authenticate.
 * @author: zouxiang
 * @date:
 */
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     */
    public function __construct()
    {
        $this->auth = "";
    }

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param string $permissionCode
     * @return \Illuminate\Http\RedirectResponse
     * @throws LogicException
     */
    public function handle($request, Closure $next, $permissionCode = '')
    {

        return $next($request);
    }

}
