<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/9
 * Time: 17:17
 */
namespace Rookie\Voice\Baidu;

use Rookie\Voice\HttpRequest;

class Auth
{

    private $fileName = 'voice_token.php';
    private $tokenApi = 'https://openapi.baidu.com/oauth/2.0/token';

    public function token($appkey,$appsecret)
    {
        $token = $this->getFile();

        if ( !isset($token['expires_in']) || $token['expires_in'] <= time() ) {
            $token = $this->httpPutApi($appkey,$appsecret);
            if (isset($token[0]) && $token[0] === null) {
                return $token;
            }
            $this->setFile($token);
        }

        return $token;
    }

    /**
     * 对接接口
     * @param string $appkey
     * @param string $appsecret
     * @return array|bool
     */
    private function httpPutApi($appkey,$appsecret)
    {
        $url = $this->tokenApi . '?grant_type=client_credentials&client_id=' . $appkey . '&client_secret=' . $appsecret;
        $result = HttpRequest::request($url);
        $token = json_decode($result,true);
        if(isset($token['error']) && $token['error'] != ''){
            return array(null,'error:' . $token['error'] . ',error_description:' . $token['error_description']);
        }

        $token['expires_in'] = time() + $token['expires_in'];

        return $token;
    }

    /**
     * //token 保存地址
     */
    private function getPath()
    {
        return str_replace('\\','/',realpath(dirname(__FILE__).'/../../')) . DIRECTORY_SEPARATOR . $this->fileName;
    }

    /**
     * 保存文件
     * @param array $data
     * @return bool|array
     */
    private function setFile(array $data)
    {
        return file_put_contents($this->getPath(),json_encode($data));
    }

    /**
     * 读取本地文件
     * @return bool|string
     */
    private function getFile()
    {
        return json_decode(file_get_contents($this->getPath()),true);
    }

}