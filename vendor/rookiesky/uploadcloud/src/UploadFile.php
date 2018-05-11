<?php

namespace Rookie\Cloud;

use Psr\Log\InvalidArgumentException;
use Rookie\Cloud\Aliyun\Upload as oss;
use Rookie\Cloud\Qiniu\Upload as qiniu;

class UploadFile
{
    const ENGINE_TYPE = ['qiniu','oss'];
    //云端
    private $engine = '';
    private $accesskey = '';
    private $secretkey = '';
    private $bucket = '';  // 包名称
    private $endpoint = '';

    public function __construct($accesskey,$secretkey,$bucket,$endpoint = '',$engine = 'qiniu')
    {
        $this->accesskey = $accesskey;
        $this->secretkey = $secretkey;
        $this->bucket = $bucket;
        $this->engine = $engine;
        $this->endpoint = $endpoint;

        $this->checkConfig();

    }

    /**
     * 选择云端
     * @return Upload
     */
    public function uploadManager()
    {
        if ($this->engine == 'qiniu') {
            return new qiniu($this->accesskey,$this->secretkey,$this->bucket);
        }
        if ($this->endpoint == 'oss') {
            return new oss($this->accesskey,$this->secretkey,$this->bucket,$this->endpoint);
        }
    }

    /**
     * 检查参数
     */
    private function checkConfig()
    {
        if (empty($this->accesskey)) {
            throw new InvalidArgumentException('accesskey is empty');
        }
        if (empty($this->secretkey)) {
            throw new InvalidArgumentException('secretkey is empty');
        }
        if(empty($this->bucket)){
            throw new InvalidArgumentException('bucket is empty');
        }
        if(in_array($this->engine,self::ENGINE_TYPE) == false){
            throw new InvalidArgumentException('不支持的云端');
        }
    }
}

