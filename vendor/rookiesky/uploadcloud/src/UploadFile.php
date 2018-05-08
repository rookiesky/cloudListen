<?php

namespace Rookie\Cloud;


use Rookie\Cloud\Qiniu\Auth;
use Rookie\Cloud\Qiniu\DeleteFile;
use Rookie\Cloud\Qiniu\FileInfo;
use Rookie\Cloud\Qiniu\Upload;

class UploadFile
{
    private static $accessKey = null;   //公钥
    private static $secretKey = null;   //私钥
    private static $backetName = null;  //空间名称
    public $errorMsg = '';  //错误信息
    private static $file = null; //上传源文件
    public $pathInfo = null; //文件信息 例如：[▼"dirname" => "/home/vagrant/Code/qiniu""basename" => "1.jpg""extension" => "jpg""filename" => "1"]
    public $size = 0;   //文件大小
    public $ext = ['jpg','jpeg','wav','mp3'];
    public $maxSize = 10;  //单位MB。允许上传的最大文件

    /**
     * 上传
     * @param string $file 文件路劲
     * @param string $newFileName  新文件名
     * @return bool|array
     */
    public function upload($file,$newFileName = null)
    {

        self::$file = $file;

        if ($this->checkFile() == false) {
            return false;
        }

       $uploadFile = new Upload();
       $result = $uploadFile->uploadFile( $this->Auth()->uploadToken(), $file, $this->fileName($newFileName) );

       if ($result == false) {
            $this->errorMsg = $uploadFile->errorMsg;
            return false;
       }
        return $result;
    }

    /**
     * 上传对象
     * @param string $fileName  文件名称
     * @param string|array|object $data 上传数据
     * @param string $mime 文件类型mimeType
     * @return bool|array
     */
    public function put($fileName,$data,$mime = 'application/octet-stream')
    {
        if (empty($fileName)){
            $this->errorMsg = '文件名称不能为空';
            return false;
        }

        if (empty($data)) {
            $this->errorMsg = '数据不能为空！';
        }

        $putFile = new Upload();
        $result = $putFile->put($this->Auth()->uploadToken(),$fileName,$data,$mime);

        if ($result == false) {
            $this->errorMsg = $result;
            return false;
        }
        return $result;

    }

    /**
     * 删除文件
     * @param $file
     * @return bool
     */
    public function delete($file)
    {

        $bucketName = self::$backetName;
        $auth = $this->Auth();

        $FileInfo = new FileInfo();
        $isFile = $FileInfo->getFileInfo($auth,$bucketName,$file);
        if ($isFile == false) {
            $this->errorMsg = $FileInfo->errorMsg;
            return false;
        }

        $deleteFile = new DeleteFile();

        $result = $deleteFile->delete($auth,$bucketName,$file);

        if ($result == false) {
            $this->errorMsg = $deleteFile->errorMsg;
            return false;
        }
        return true;

    }

    /**
     * 批量删除文件
     * @param array $files 指定文件名
     * @return bool
     */
    public function buiBatchDelete($files)
    {
        $deleteFile = new DeleteFile();
        $result = $deleteFile->buiBatchDelete($this->Auth(),self::$backetName,$files);

        if ($result == false) {
            $this->errorMsg = $deleteFile->errorMsg;
            return false;
        }
        return true;
    }

    /**
     * 根据指定前缀获取文件
     * @param string $prefix 前缀名称
     * @return bool|array
     */
    public function getPrefixFile($prefix)
    {
        $fileInfo = new FileInfo();
        $result = $fileInfo->getPrefixFile($this->Auth(),$prefix,self::$backetName);

        if ($result == false) {
            $this->errorMsg = $fileInfo->errorMsg;
            return false;
        }
        if (count($result['items']) < 1) {
            $this->errorMsg = '指定前缀文件为空！';
            return false;
        }
        return $result['items'];
    }

    /**
     * 鉴权对象
     * @return Auth
     */
    private function Auth()
    {
        return new Auth(self::$accessKey,self::$secretKey,self::$backetName);
    }

    /**
     * 检查文件
     * @return bool
     */
    private function checkFile()
    {

        if ($this->checkCloudInfo() == false) {
            return false;
        }

        $this->fileInfo();

        if ($this->pathInfo['dirname'] == '') {
            $this->errorMsg = '请选择需要上传的文件';
            return false;
        }

        if ($this->size <= 0) {
            $this->errorMsg = '文件大小不能为零！';
            return false;
        }

        if (in_array($this->pathInfo['extension'],$this->ext) == false) {
            $this->errorMsg = '不被允许上传的文件类型！';
            return false;
        }

        if ($this->size > $this->maxSize) {
            $this->errorMsg = '文件大小超限，请不要上传超过'.$this->maxSize . 'MB的文件！';
            return false;
        }

        return true;
    }

    /**
     * 处理文件名称
     * @param string $fileName 文件名
     * @return string
     */
    private function fileName($fileName = null)
    {
        if ($fileName != null) {
            return $fileName;
        }

        return date('Y-m') . '/' . time() . '.' . $this->pathInfo['extension'];

    }

    /**
     * 获取文件信息
     */
    private function fileInfo()
    {
        //1048576 等于1M  获取的值单位MB
        $this->size = round(filesize(self::$file) / 1048576,2);

        $this->pathInfo = pathinfo(self::$file);


    }

    /**
     * 检查初始化信息
     * @return bool
     */
    private function checkCloudInfo()
    {
        if (empty(self::$backetName)) {
            $this->errorMsg = '空间名称不能为空';
            return false;
        }

        if (empty(self::$accessKey)) {
            $this->errorMsg = '公钥不能为空';
            return false;
        }

        if (empty(self::$secretKey)) {
            $this->errorMsg = '私钥不能为空';
            return false;
        }
        return true;
    }

    /**
     * 初始化
     * @param $accesskey   公钥
     * @param $secretkey  私钥
     * @param $bucketName  空间名称
     */
    public function setInfo($accesskey,$secretkey,$bucketName)
    {
        self::$accessKey = $accesskey;
        self::$secretKey = $secretkey;
        self::$backetName = $bucketName;
    }

}