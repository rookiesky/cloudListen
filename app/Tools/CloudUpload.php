<?php

namespace App\Tools;

use Rookie\Cloud\UploadFile;

class CloudUpload
{

    public function join()
    {
        $config = getConfig('upload');
        try{
            $upload = new UploadFile($config['QINIU_ACCESSKEY'],$config['QINIU_SECRETKEY'],$config['QINIU_BUCKET']);
            return $upload->uploadManager();
        }catch (\Exception $e){
            return ['error'=>$e->getMessage()];
        }
    }


}