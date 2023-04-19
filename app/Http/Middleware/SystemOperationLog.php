<?php
namespace App\Http\Middleware;

use App\Library\Admin\Log\SystemLogBuilder;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class SystemOperationLog
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    protected $route;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = \Auth::guard('admin');
    }


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->auth->guest()) {
            $systemLogBuilder = new SystemLogBuilder();
            self::login($systemLogBuilder);
            $route = $request->route()->getAction();

            $systemLogBuilder->make($request, $route['as']);
        }
        return $next($request);
    }

    public function routeParam($functionBlock, $action, $business_no = 'id', $regulation = [])
    {
        return [
            'function_block' => $functionBlock,
            'action' => $action,
            'business_no' => $business_no,
            'regulation' => $regulation
        ];
    }


    public function login($obj) {
        $obj->setRoute('m.logout', self::routeParam('用户', '用户退出', 0));
    }


}
