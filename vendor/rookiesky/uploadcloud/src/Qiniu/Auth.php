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

    public function __construct($accesskey,$secretkey)
    {
        if (self::$auth == null) {
            self::$auth = new \Qiniu\Auth($accesskey,$secretkey);
        }
    }

    public function token($bukcet)
    {
        $token = self::$auth->uploadToken($bukcet);
        dd($token);
    }

}