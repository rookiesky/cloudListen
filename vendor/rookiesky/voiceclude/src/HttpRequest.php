<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/9
 * Time: 17:45
 */

namespace Rookie\Voice;


class HttpRequest
{
    /**
     * Http Request POST OR GET
     * @param string $url  接口地址
     * @param null $data  发送数据
     * @param null $header header
     * @return mixed
     */
    public static function request (string $url,$data = null,$header = null) {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        if($header != null){
            curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        }
        if (!empty($data)) {
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}