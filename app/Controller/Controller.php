<?php

namespace App\Controller;


use App\Tools\HttpRequest;

class Controller
{
    /**
     * 统一输出
     * @param int $status 状态码 正常为0
     * @param string $msg 反馈说明
     * @param string $data 反馈数据
     * @return json
     */
    public function putMsg(int $status,$msg = '',$data = '')
    {
        $response = new HttpRequest();
        return $response->responseJson([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}