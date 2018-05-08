<?php

namespace App\Tools;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HttpRequest
{
    //http request 对象
    public static $request = null;

    /**
     * http request
     * @return null|static
     */
    public function request()
    {
        if (self::$request == null) {

            self::$request = Request::createFromGlobals();

        }
        return self::$request;
    }

    /**
     * 发送json数据
     * @param array $data
     */
    public function responseJson(array $data)
    {
        $response = new JsonResponse();
        $response->setData($data);
        $response->send();
    }

}