<?php

namespace Rookie\Voice;

interface VoiceInterface
{

    //对外接口
    public function getVoice($text,$cuid);
    //初始化配置
    public static function setInit($data);
}