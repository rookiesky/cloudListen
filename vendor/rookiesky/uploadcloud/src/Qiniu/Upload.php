<?php

namespace Rookie\Cloud\Qiniu;


use Qiniu\Storage\UploadManager;

class Upload
{

    public $errorMsg;  //错误信息

    /**
     * 上传文件
     * @param string $token 上传令牌
     * @param string $file 文件路径
     * @param string $cloudFileName 重命名
     * @return bool|array
     */
    public function uploadFile($token,$file,$cloudFileName)
    {
        list($ret,$err) = $this->uploadManager()->putFile($token,$cloudFileName,$file);
        if($err != null){
            $this->errorMsg = $err;
            return false;
        }
        return $ret;
    }

    /**
     * 上传对象
     * @param string $token  上传令牌
     * @param string $fileName 文件名称
     * @param string|array|object $data
     * @param string $mime 文件mimeType
     * @return bool|array
     */
    public function put($token,$fileName,$data,$mime)
    {

        list($ret, $err) = $this->uploadManager()->put($token, $fileName, $data,null,$mime);

        if($err != null){
            $this->errorMsg = $err;
            return false;
        }
        return $ret;
    }

    private function uploadManager()
    {
        return new UploadManager();
    }


}