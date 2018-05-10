<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/10
 * Time: 20:50
 */

namespace Rookie\Cloud\Qiniu;


class Auth
{
    private $bucket = null;
    private static $auth = null;


    public function init($accesskey,$secretkey)
    {
        if (self::$auth == null) {
            self::$auth = new \Qiniu\Auth($accesskey,$secretkey);
        }
        return self::$auth;
    }

    /**
     * 上传令牌
     * @param string $bukcet 包名称
     * @return string
     */
    public function token($bukcet)
    {
        return self::$auth->uploadToken($bukcet);
    }

}