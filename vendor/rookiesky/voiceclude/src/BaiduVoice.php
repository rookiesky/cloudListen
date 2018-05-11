<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/9
 * Time: 14:50
 */

namespace Rookie\Voice;


use Rookie\Voice\Baidu\Auth;
use Rookie\Voice\Baidu\StringFormat;

class BaiduVoice implements VoiceInterface
{
    private static $appkey = null;
    private static $appsecret = null;

    private static $ctp = 1;   //客户端类型选择，web端填写固定值1
    private static $lan = 'zh';  //固定值zh。语言选择,目前只有中英文混合模式，填写固定值zh
    private static $spd = 5; //语速，取值0-9，默认为5中语速
    private static $pit = 5;  //音调，取值0-9，默认为5中语调
    private static $vol = 5;  //音量，取值0-15，默认为5中音量
    private static $per = 3;  //发音人选择, 0为普通女声，1为普通男生，3为情感合成-度逍遥，4为情感合成-度丫丫，默认为普通女声
    private static $num = 1;  //语音条数

    const APIURL = 'http://tsn.baidu.com/text2audio?';


    public function getVoice($text,$cuid)
    {
        $token = $this->token();
        if (current($token) === null) {
            return $token;
        }

        $strFormat = new StringFormat();
        $str = $strFormat->format($text,self::$num);

        if (self::$num > 1 && isset($str[0])) {

            return $this->manyVoice($str,$token['access_token'],$cuid);

        }else{
            $data = $this->put($str['text'],$token['access_token'],$cuid);
            if (self::voiceISTure($data)) {
                return array(null,json_decode($data,true));
            }
            return [
                'voice' => $data,
                'text' => $str['text'],
                'length' => $str['length']
            ];
        }

    }

    /**
     * 解析多条语音
     * @param string $texts 文本内容
     * @param string $token 令牌
     * @param string $cuid 发送者
     * @return array
     */
    private function manyVoice($texts,$token,$cuid)
    {
        $data = [];
        foreach ($texts as $key=>$val){
            $voice = $this->put($val['text'],$token,$cuid);
            if(self::voiceISTure($voice)){
                return array(null,json_decode($voice,true));
            }
            $data[$key]['voice'] = $voice;
            $data[$key]['text'] = $val['text'];
            $data[$key]['length'] = $val['length'];
        }
        return $data;
    }

    /**
     * 判断是否为JSON格式
     * @param $data
     * @return bool
     */
    private static function voiceISTure($data)
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 合成音频
     * @param string $text
     * @param string $token
     * @param string $cuid
     * @return string|json
     */
    private function put($text,$token,$cuid)
    {
        $star = microtime(true);
        $pram = 'tex=' . urlencode($text) . '&tok=' . $token . '&cuid=' . $cuid . '&ctp=' . self::$ctp . '&lan=' . self::$lan . '&spd=' . self::$spd . '&pit=' . self::$pit . '&vol=' . self::$vol . '&per=' . self::$per;
        $url = self::APIURL . $pram;

        HttpRequest::request($url);
        $stop = microtime(true);
        echo "time:" . ($stop - $star);die;
    }

    /**
     * 获取token
     */
    private function token()
    {
        $auth = new Auth();
        return $auth->token(self::$appkey,self::$appsecret);
    }

    /**
     * 初始化配置
     * @param $data
     * @return array
     */
    public static function setInit($data)
    {
        if (empty($data)) {
            return array(null,'配置信息不能为空');
        }

        self::$appkey = $data['accesskey'];
        self::$appsecret = $data['scretkey'];
        self::$spd = $data['spd'];
        self::$pit = $data['pit'];
        self::$vol = $data['vol'];
        self::$per = $data['per'];
        self::$num = $data['num'];
    }
}