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
        if ($err !== null) {
            return [$ret,$err];
        }

        return $this->putMsg($ret['oss-request-url'],$ret['content-md5'],$err);

    }

    /**
     * 上传文件
     * @param string $fileName
     * @param string $filePath
     * @return array
     */
    public function upload(string $fileName, string $filePath)
    {
            $ret = null;
            $err = null;

            try{
                $ret = $this->client()->uploadFile($this->bucket,$fileName,$filePath);
            }catch(OssException $e)
            {
                $err = $e->getMessage();
            }

        if ($err !== null) {
            return [$ret,$err];
        }

        return $this->putMsg($ret['oss-request-url'],$ret['content-md5'],$err);
    }

    /**
     * 删除单个文件
     * @param string $fileName
     * @return array
     */
    public function delete(string $fileName)
    {
        $ret = null;
        $err = null;

        try{
            $ret = $this->client()->deleteObject($this->bucket,$fileName);
        }catch (OssException $e)
        {
            $err = $e->getMessage();
        }
        if ($err !== null) {
            return [$ret,$err];
        }
        return $this->putMsg($ret['oss-request-url'],'',$err);
    }

    public function buildBatchDelete(array $files)
    {
        $ret = null;
        $err = null;

        try{
            $ret = $this->client()->deleteObjects($this->bucket,$files);
        }catch (OssException $e)
        {
            $err = $e->getMessage();
        }
        if ($err !== null) {
            return [$ret,$err];
        }
        dd($ret);
    }

    /**
     * 统一输出格式
     * @param string $key
     * @param $hash
     * @param $err
     * @return array
     */
    private function putMsg($key,$hash,$err)
    {
        return [
            [
                'key' => $key,
                'hash' => $hash
            ],
            $err
        ];
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