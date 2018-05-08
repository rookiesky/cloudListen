<?php

namespace RookieVoice;


class HttpRequestString
{

    const XUNFEILENGTH = 994;   //讯飞语音接口单条语音最多字节

    const MAXNUM = 3;   //最大条数

    private static $text;  //原始文本
    private $length = 0;  //文本长度
    private $isNum = 1;

    /**
     * 设置语音条数
     * @param int $isNum
     */
    public function setIsNum($isNum)
    {
        $this->isNum = $isNum;
    }

    public $errorMsg = ''; //错误信息

    /**
     * 抛出字符串
     * @param string $text
     * @return array|bool|string
     */
    public function getText($text)
    {
        self::$text = $text;
        $this->stringLength();
        $check = $this->checkLength();
        if ($check == false) {
            $this->errorMsg;
            return false;
        }

        return $this->str();
    }

    /**
     * 处理字符串
     * @return array|bool|string
     */
    private function str()
    {

        $text = self::$text;

        if ($this->length <= self::XUNFEILENGTH) {
            return $text;
        }

        if ($this->length > self::XUNFEILENGTH && $this->isNum == 1) {
            return "text=" . substr($text,0,self::XUNFEILENGTH);
        }

        if ($this->isNum > 1) {
            return $this->substrText();
        }
        return false;
    }

    /**
     * 截取字符串
     * @return array
     */
    private function substrText()
    {
        $star = self::XUNFEILENGTH;
        $str = array();
        $text = self::$text;

        for ( $i=0; $i<$this->isNum; $i++ ){
            $str[] = "text=" . substr($text,($star * $i),$star);
        }
        return $str;
    }

    /**
     * 检查字节是否超限
     * @return bool
     */
    private function checkLength()
    {
        if($this->isNum > self::MAXNUM){
            $this->errorMsg = '设置语音条数大于可设置最大条数(3条)';
            return false;
        }
        return true;
    }

    /**
     * 文本字节
     */
    private function stringLength()
    {
        $this->length = strlen(self::$text);
    }

}