<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/6
 * Time: 20:28
 */

namespace Rookie\Cloud\Qiniu;


class FileInfo
{
    public $errorMsg; //错误信息

    /**
     * 查询文件信息
     * @param $backetName 空间名称
     * @param $file 查询文件名称
     * @return bool
     */
    public function getFileInfo($auth,$backetName,$file)
    {

        list($fileInfo,$err) = $auth->getBucketManager(true)->stat($backetName,$file);

        if($err != null){
            $this->errorMsg = $err;
            return false;
        }
        return $fileInfo;
    }

    /**
     * 获取指定前缀文件
     * @param new \Rookie\Cloud\Qiniu\Auth $auth
     * @param string $prefix  文件前缀
     * @param string $bucket 空间名称
     * @return bool
     */
    public function getPrefixFile($auth,$prefix,$bucket)
    {

        if(empty($prefix)){
            $this->errorMsg = '前缀不能为空';
            return false;
        }

        // 上次列举返回的位置标记，作为本次列举的起点信息。
        $marker = '';
        // 本次列举的条目数
        $limit = 100;
        $delimiter = '-';

        list($ret,$err) = $auth->getBucketManager()->listFiles($bucket, $prefix, $marker, $limit, $delimiter);

        if($err != null){
            $this->errorMsg = $err;
            return false;
        }
        return $ret;

    }

}