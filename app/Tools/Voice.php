<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/8
 * Time: 22:18
 */

namespace App\Tools;


class Voice
{
    /**
     * 语音接口
     * @param string $text
     * @param int $num
     * @param string $cuid
     * @return array|bool|string
     */
    public function put($text,$num = 1,$cuid = 'local')
    {
        $voice = new \Rookie\Voice\Voice();
        $config = getConfig('voice');
        if (empty($config['APPID']) || $config['APIKEY'] == '') {
            return array(null,'APPID或SECRETKEY不能为空');
        }
        $voice->setTokenInfo($config['APPID'],$config['APIKEY']);
        $voice->num = $num;
        return $voice->getVoice($text,$cuid);
    }


}