<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/10
 * Time: 19:26
 */

namespace Rookie\Cloud\Qiniu;


use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
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

    /**
     * 上传对象
     * @param array|string|json|object $data 文件数据
     * @param string $fileName  文件重命名
     * @param string $mime mimetype
     * @return array [$ret,$error = null]
     */
    public function put($data,$fileName = null,$mime = 'application/octet-stream')
    {
         return $this->uploadManager()
            ->put(
                $this->token(),
                $fileName,
                $data,
                null,
                $mime
            );
    }

    /**
     * 上传文件
     * @param string $fileName
     * @param string $filePath 文件路劲
     * @return array [$ret,$error = null]
     */
    public function upload(string $fileName,string $filePath)
    {
       return $this->uploadManager()
           ->putFile(
               $this->token(),
               $fileName,
               $filePath
            );
    }

    /**
     * 删除文件
     * @param string $fileName
     * @return mixed 成功返回null,失败返回错误信息
     */
    public function delete(string $fileName)
    {
        return $this->bucketManager($this->Auth(),$this->config())
            ->delete($this->bucket,$fileName);
    }

    /**
     * 批量删除文件
     * @param array $files 文件数组
     * @return array [$ret,$err] 执行成功$err为空
     */
    public function buildBatchDelete(array $files)
    {
        $bucketManager = $this->bucketManager($this->Auth(),$this->config());
        $ops = $bucketManager->buildBatchDelete($this->bucket,$files);
        return $bucketManager->batch($ops);

    }

    private function bucketManager($auth,$config = null)
    {
        return new BucketManager($auth,$config);
    }

    private function config(){
        return new Config();
    }

    /**
     * 上传控制
     * @return UploadManager
     */
    private function uploadManager()
    {
        return new UploadManager();
    }

    /**
     * 鉴权
     * @return Auth
     */
    private function Auth()
    {
        return new \Qiniu\Auth($this->accesskey,$this->secretkey);
    }

    private function token()
    {
        return $this->Auth()->uploadToken($this->bucket);
    }
}