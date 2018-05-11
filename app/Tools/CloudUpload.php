<?php

namespace App\Tools;

use Rookie\Cloud\UploadFile;

class CloudUpload
{

    public function join()
    {
        $config = getConfig('upload');
        try{
            $upload = new UploadFile($config['OSS_ACCESSKEY'],$config['OSS_ACCESS_KEY_SECRET'],$config['OSS_BUCKET'],$config['OSS_ENDPOINT'],'oss');
            return $upload->uploadManager();
        }catch (\Exception $e){
            return ['error'=>$e->getMessage()];
        }
    }


}