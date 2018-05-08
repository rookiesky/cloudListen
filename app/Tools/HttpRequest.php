<?php

namespace App\Tools;

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
         header('HTTP/1.0 200 OK', true, 200);
         header('Content-type: application/json');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit();
    }

}