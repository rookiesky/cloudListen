<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/11
 * Time: 13:26
 */

namespace Rookie\Cloud\Aliyun;

use OSS\Core\OssException;
use OSS\OssClient;
use Rookie\Cloud\UploadInterface;

class Upload implements UploadInterface
{

    private $accesskey = '';
    private $accessKeySecret = '';
    private $endpoint = '';
    private $bucket = '';

    /**
     * Upload constructor.
     * @param string $accesskey
     * @param string $accessKeySecret
     * @param string $endpoint
     */
    public function __construct($accesskey, $accessKeySecret, $bucket, $endpoint)
    {
        $this->accesskey = $accesskey;
        $this->accessKeySecret = $accessKeySecret;
        $this->endpoint = $endpoint;
        $this->bucket = $bucket;
    }

    /**
     * 上传对象
     * @param array|object|\Rookie\Cloud\json|string $data
     * @param null $fileName
     * @return array
     */
    public function put($data, $fileName = null)
    {
        $ret = null;
        $err = null;

        try{
            $ret = $this->client()->putObject($this->bucket,$fileName,$data);
        }catch (OssException $e)
        {
            $err = $e->getMessage();
        }
        return [$ret,$err];
    }
    public function upload(string $fileName, string $filePath)
    {
        // TODO: Implement upload() method.
    }
    public function delete(string $fileName)
    {
        // TODO: Implement delete() method.
    }
    public function buildBatchDelete(array $files)
    {
        // TODO: Implement buildBatchDelete() method.
    }

    /**
     * 初始化上传
     * @return OssClient|string
     */
    private function client()
    {
        try{
            return new OssClient($this->accesskey,$this->accessKeySecret,$this->endpoint);
        }catch(OssException $e)
        {
            return $e->getMessage();
        }
    }

}