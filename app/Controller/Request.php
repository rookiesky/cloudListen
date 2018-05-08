<?php

namespace App\Controller;


use App\Tools\HttpRequest;

class Request extends Controller
{

    public function request()
    {
        $request = new HttpRequest();

       if ($request->request()->isMethod('post') === true || $request->request()->isMethod('get') === true) {

            $text = $request->request()->get('text');

            if (empty($text)) {
                return array(null,'text参数为空');
            }

            if (!is_string($text)){
                return array(null,'参数类型不对，只能是字符串类型');
            }

            return [
                'text' => $this->stringFormat($text),
                'ip' => $this->getClientIp()
            ];

       }

       abort(404);

    }

    /**
     * 获取客户端IP
     * @return mixed
     */
    private function getClientIp()
    {
        $request = new HttpRequest();
        return $request->request()->getClientIp();
    }

    /**
     * 去除HTML标签并格式化字符串
     * @param string $str
     * @return string
     */
    private function stringFormat(string $str) : string
    {
        return htmlspecialchars(strip_tags($str));
    }

}