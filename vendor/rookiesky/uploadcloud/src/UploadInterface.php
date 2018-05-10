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
    /**
     * 上传对象
     * @param array|string|object|json $data 对象数据
     * @param string $fileName 文件名称
     * @return array
     */
    public function put($data,$fileName = null);

    /**
     * 上传文件
     * @param string $fileName 云端文件名称
     * @param string $filePath 上传文件路径
     * @return array
     */
    public function upload(string $fileName,string $filePath);

    /**
     * 删除单个文件
     * @param string $fileName
     * @return mixed 成功返回NULL，失败返回错误信息
     */
    public function delete(string $fileName);

    /**
     * 批量删除文件
     * @param array $files 文件数组
     * @return array [$ret,$err] 执行成功$err为空
     */
    public function buildBatchDelete(array $files);
}