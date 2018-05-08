<?php

namespace Rookie\Cloud\Qiniu;

use Qiniu\Auth as SdkAuth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;

class Auth
{

    private static $backetName = '';
    private $accesskey = null;
    private $secretkey = null;

    public function __construct($accesskey,$secretkey,$backetName)
    {

        self::$backetName = $backetName;

        $this->accesskey = $accesskey;
        $this->secretkey = $secretkey;

    }

    /**
     * 鉴权对象
     * @return SdkAuth
     */
    public function newAuth()
    {
       return new SdkAuth($this->accesskey,$this->secretkey);
    }
    /**
     * 上传令牌
     * @return string
     */
    public function uploadToken()
    {
        return $this->newAuth()->uploadToken(self::$backetName);
    }

    /**
     * @return Config
     */
    public static function config()
    {
        return new Config();
    }

    /**
     * 实例化区块对象
     * @param  bool $config
     * @return BucketManager
     */
    public function getBucketManager($config = false)
    {

        if ($config == false) {
            return new BucketManager($this->newAuth());
        }

        return new BucketManager($this->newAuth(),$this->config());
    }

}