<?php

namespace Rookie\Voice;


class Voice
{

    const MAXNUM = 10;  //单次最多生成语音量
    const MAXPAR = 9;  //参数最大值

    public $engine = 'baidu';  //语音接口 百度,讯飞
    public $spd = 5;    //语速 0-9
    public $pit = 5;    //雨调 0-9
    public $vol = 5;    //音量 0-9
    public $per = 3;   //发音人
    public $num = 1;   //语音条数

    private $accesskey = null;
    private $secretkey = null;


    public function getVoice($text,$cuid = 'local')
    {
        if (empty($text)) {
            return array(null,'文本内容不能为空');
        }
        $check = $this->checkPram();
        if ($check != true){
            return $check;
        }

        $voice = $this->setInit();
        return $voice->getVoice($text,$cuid);

    }

    /**
     * 参数检测
     * @return array|bool
     */
    private function checkPram()
    {
        if ($this->accesskey == null) {
            return array(null,'accesskey不能为空');
        }
        if ($this->secretkey == null) {
            return array(null,'secretkey不能为空');
        }
        if ($this->num > self::MAXNUM) {
            return array(null,'语音条数超出限制');
        }
        return true;
    }

    /**
     * 初始化引擎
     * @return BaiduVoice
     */
    private function setInit()
    {
        if($this->engine == 'baidu'){
            BaiduVoice::setInit([
                'accesskey' => $this->accesskey,
                'scretkey' => $this->secretkey,
                'spd' => $this->spd,
                'pit' => $this->pit,
                'vol' => $this->vol,
                'per' => $this->per,
                'num' => ($this->num < 1) ? 1 : $this->num
            ]);
            return new BaiduVoice();
        }
    }

    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * 设置鉴权信息
     * @param string $accesskey
     * @param string $secretkey
     */
    public function setTokenInfo(string $accesskey,string $secretkey)
    {
        $this->accesskey = $accesskey;
        $this->secretkey = $secretkey;
    }

}