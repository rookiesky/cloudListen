<?php

namespace Rookie\Cloud\Qiniu;

class DeleteFile
{

    public $errorMsg; //错误信息

    /**
     * 删除单个文件
     * @param string $bucketName  空间名称
     * @param string $file  删除名称
     * @return bool
     */
    public function delete($auth,$bucketName,$file)
    {

        $err = $auth->getBucketManager(true)->delete($bucketName,$file);

        if ($err != null) {
            $this->errorMsg = $err;
            return false;
        }
        return true;
    }

    /**
     * 批量删除文件
     * @param new Auth $auth 鉴权
     * @param string $buckeName 空间名称
     * @param array $files 指定文件
     * @return bool
     */
    public function buiBatchDelete($auth,$buckeName,$files)
    {
        if (empty($files)) {
            $this->errorMsg = '文件不能为空';
            return false;
        }

        $bucketManager = $auth->getBucketManager(true);

        $ops = $bucketManager->buildBatchDelete($buckeName,$files);

        list($ret,$err) = $bucketManager->batch($ops);

        if ($err != null) {
            $this->errorMsg = $err;
            return false;
        }
        return true;
    }

}