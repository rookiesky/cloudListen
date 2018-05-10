<?php

namespace Rookie\Voice\Baidu;

class StringFormat
{

    const TEXTLENGTH = 510;   //单条语音最大字数

    private static $text = ''; //原始文本
    private $num = 1;  //转换文本条数

    public function format($text,$num)
    {

        $this->num = $num;
        self::$text = strip_tags($text);
        return $this->subString();

    }

    /**
     * 格式化字符串
     * @return array
     */
    private function subString()
    {
        $text = self::$text;

        $length = $this->strLength($text);

        if ($this->num == 1) {
            if ($length <= self::TEXTLENGTH) {
                return [
                    'text' => $text,
                    'length' => $length
                ];
            }

            if ($length > self::TEXTLENGTH) {
                return [
                    'text' => mb_substr($text,0,self::TEXTLENGTH),
                    'length' => self::TEXTLENGTH
                ];
            }

        }

        return $this->manyString();

    }

    /**
     * 截取字符串
     * @return array
     */
    private function manyString()
    {
        $text = self::$text;
        $str = [];

        for ($i=0;$i < $this->num;$i++){
            $str[$i]['text'] = mb_substr($text,($i * self::TEXTLENGTH),self::TEXTLENGTH);
            $str[$i]['length'] = $this->strLength($str[$i]['text']);
        }

        return $str;

    }

    /**
     * 获取字符串字数
     * @param string $text
     * @return int
     */
    private function strLength(string $text)
    {

        return mb_strlen(iconv("UTF-8", "GBK", $text), "GBK");
    }
}