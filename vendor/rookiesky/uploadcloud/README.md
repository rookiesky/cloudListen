# 云上传库

- 目前支持骑牛上传

## 使用
````
$uplod = new \Rookie\Cloud\UploadFile();  //实例化
$uplod->setInfo($accessKey,$secretKey,$backName);  //初始化配置
//$accessKey  公钥
//$secretKey  私钥
//$backName  空间名称

//上传文件
$uplod->upload($file,$newFileName); //$fiel 文件地址，绝对路劲 $newFileName 文件重命名，可空

//删除单个文件
$upload->delete($fileName);  //$fileName 文件名称

//批量删除文件
$upload->buiBatchDelete(array());

//上传对象
$upload->put('文件数据',文件重命名','文件类型');

````