<?php

namespace Rookie\Cloud;

use Psr\Log\InvalidArgumentException;
use Rookie\Cloud\Qiniu\Upload;

class UploadFile
{
    const ENGINE_TYPE = ['qiniu'];
    //云端
    private $engine = '';
    private $accesskey = '';
    private $secretkey = '';
    private $bucket = '';  // 包名称

    public function __construct($accesskey,$secretkey,$bucket,$engine = 'qiniu')
    {
        $this->accesskey = $accesskey;
        $this->secretkey = $secretkey;
        $this->bucket = $bucket;
        $this->engine = $engine;

        $this->checkConfig();

    }

    /**
     * 选择云端
     * @return Upload
     */
    public function uploadManager()
    {
        if ($this->engine == 'qiniu') {
            return new Upload($this->accesskey,$this->secretkey,$this->bucket);
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

