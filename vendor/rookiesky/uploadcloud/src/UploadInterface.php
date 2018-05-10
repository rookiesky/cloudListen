<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/10
 * Time: 19:22
 */

namespace Rookie\Cloud;


interface UploadInterface
{
    //对象上传
    public function put($data,$fileName = null);
    //上传文件
    public function upload(string $fileName,string $filePath);
    //删除文件
    public function delete();
}