<?php

namespace App\Admin\Controllers\Api;

use App\Admin\Bls\Api\ApiBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use App\Library\Rpc\Exception\BusinessProtocolException;
use Illuminate\Http\Request;
use View;

class ApiDemoController extends Controller
{
    public function index()
    {
        $apiList = ApiBls::getApiList();
        return View::make('admin::api.demo.index',[
            'list' => $apiList
        ]);
    }


    public function methods(Request $request)
    {
        $class = $request->get("class");

        $title = ApiBls::getApiDesc($class);
        $methodsList = ApiBls::getMethodsList($class);
        return View::make('admin::api.demo.methods', [
            'title' => $title,
            'class' => $class,
            'list' => $methodsList,
        ]);
    }

    public function detail(Request $request)
    {
        $class = $request->get("class");
        $method = $request->get("method");
        $param = ApiBls::getMethodParam($class, $method);
        $classDesc = ApiBls::getApiDesc($class);
        $methodDesc = ApiBls::getMethodDesc($class, $method);

        return View::make('admin::api.demo.detail', [
            'class' => $class,
            'method' => $method,
            'classDesc' => $classDesc,
            'methodDesc' => $methodDesc,
            'param' => $param,
        ]);
    }
    public function result(Request $request)
    {
        $class = $request->get("class");
        $method = $request->get("method");
        $values = $request->get("values", []);
        if ( !in_array($class, array_keys(ApiBls::getApiList()))
            || !in_array($method, array_keys(ApiBls::getMethodsList($class)))
        ) {
            return (new JsonResponse())->error(1010025, "Invalid param");
        }
        if(!empty($values)){
            foreach ($values as $key => $value){
                if(preg_match('/(^\[(.*)\]$)|(^\{(.*)\}$)/',$value,$matchs)){
                    $values[$key] = json_decode($value);
                }
            }
        }
        try {
            $class = new \ReflectionClass($class);
            $method = $class->getMethod($method);
            //判断方法是否为静态方法
            if ($method->isStatic()) {
                $res = $method->invokeArgs($class, $values);
            } else {
                $instance = $class->newInstance();
                $res = $method->invokeArgs($instance, $values);
            }
        }catch(BusinessProtocolException $e){
            return (new JsonResponse())->error(1010010, "接口返回错误: ({$e->getCode()})" . $e->getMessage());
        }

        return (new JsonResponse())->success(["result"=>json_encode($res)]);
    }
}
