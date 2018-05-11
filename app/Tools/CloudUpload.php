<?php

namespace App\Tools;

use Rookie\Cloud\UploadFile;

class CloudUpload
{

    public function join()
    {
        $config = getConfig('upload');
        try{
            //$upload = new UploadFile($config['OSS_ACCESSKEY'],$config['OSS_ACCESS_KEY_SECRET'],$config['OSS_BUCKET'],$config['OSS_ENDPOINT'],'oss');
            $upload = new UploadFile($config['QINIU_ACCESSKEY'],$config['QINIU_SECRETKEY'],$config['QINIU_BUCKET']);
            return $upload->uploadManager();
        }catch (\Exception $e){
            return ['error'=>$e->getMessage()];
        }
    }


}