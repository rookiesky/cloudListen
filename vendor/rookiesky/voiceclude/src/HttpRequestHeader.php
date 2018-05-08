<?php

namespace RookieVoice;


class HttpRequestHeader
{

    private static $appId;
    private static $param;
    private static $time;
    private static $apiKey;
    public $msg = null; //错误信息

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }


    /**
     * 抛出HEADER信息
     * @param $param
     * @return array|null
     */
    public function getHttpHeader($param)
    {
        $this->setCurTime();
        $this->param($param);
        $check = $this->check();

        if ($check === false) {
            return $this->msg;
        }

        $checksum = $this->checkSum();
        $header = [];
        $header[] = 'X-CurTime:'.self::$time;
        $header[] = 'X-Param:'.self::$param;
        $header[] = 'X-Appid:'.self::$appId;
        $header[] = 'X-CheckSum:'.$checksum;
        $header[] = 'X-Real-Ip:'.$this->getServerIp();
        $header[] = 'Content-Type:application/x-www-form-urlencoded; charset=utf-8';

        return $header;
    }

    /**
     * md5哈希计算令牌
     * @return string
     */
    private function checkSum()
    {
        return md5(self::$apiKey . self::$time . self::$param);
    }

    /**
     * 获取服务器IP
     * @return string
     */
    private function getServerIp()
    {
        $host = $_SERVER['HTTP_HOST'];
        return gethostbyname($host);
    }

    /**
     * 检查相关参数
     * @return bool
     */
    private function check()
    {
        if (empty(self::$appId)) {
            $this->msg = 'APPID不能为空！';
            return false;
        }

        if (empty(self::$param)) {
            $this->msg = '参数param串不能为空!';
            return false;
        }

        if(empty(self::$apiKey)){
            $this->msg = 'apikey不能为空';
            return false;
        }
        return true;
    }


    /**
     * 赋值APPI
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        self::$appId = $appId;
    }

    /**
     * 时间戳
     * @return int
     */
    private function setCurTime()
    {
        return self::$time = time();
    }

    /**
     * base64加密json字符串
     * @param array $data
     * @return string
     */
    private function param($data)
    {
        return self::$param = base64_encode(json_encode($data));
    }

}