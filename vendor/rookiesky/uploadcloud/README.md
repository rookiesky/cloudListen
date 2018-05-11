# 云上传库

- 目前支持骑牛上传

## 使用
````

//$accessKey  公钥
//$secretKey  私钥
//$backName  空间名称

try{
     //$ossUpload = new UploadFile($config['OSS_ACCESSKEY'],$config['OSS_ACCESS_KEY_SECRET'],$config['OSS_BUCKET'],$config['OSS_ENDPOINT'],'oss');
     $qiniuUpload = new UploadFile($config['QINIU_ACCESSKEY'],$config['QINIU_SECRETKEY'],$config['QINIU_BUCKET']);
       return $upload->uploadManager();
    }catch (\Exception $e){
        return ['error'=>$e->getMessage()];
    }

//上传文件
$uplod->upload($file,$newFileName); //$fiel 文件地址，绝对路劲 $newFileName 文件重命名，可空

//删除单个文件
$upload->delete($fileName);  //$fileName 文件名称

//批量删除文件
$upload->buiBatchDelete(array());

//上传对象
$upload->put('文件数据',文件重命名','文件类型');

````