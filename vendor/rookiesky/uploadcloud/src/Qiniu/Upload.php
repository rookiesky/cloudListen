<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/10
 * Time: 19:26
 */

namespace Rookie\Cloud\Qiniu;


use Rookie\Cloud\UploadInterface;

class Upload implements UploadInterface
{

    private $accesskey = null;
    private $secretkey = null;
    private $bucket = null;

    public function __construct($accesskey,$secretkey,$bucket)
    {
        $this->accesskey = $accesskey;
        $this->secretkey = $secretkey;
        $this->bucket = $bucket;
    }


    public function put()
    {
        $this->auth()->token($this->bucket);
        // TODO: Implement put() method.
    }
    public function upload()
    {
        // TODO: Implement upload() method.
    }
    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * 鉴权
     * @return Auth
     */
    private function auth()
    {
        return new Auth($this->accesskey,$this->secretkey);
    }

}