<?php
require './vendor/autoload.php';
ini_set('display_errors','on');
define('DEBUG',true);

$ak = '';
$sk = '';
$backName = '';

$upload = new \Rookie\Cloud\UploadFile();
$upload->setInfo($ak,$sk,$backName);

$path = str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/";
$file = $path . 'test.wav';

//$result = $upload->upload($file);



//$result = $upload->delete('2018-05/1525666426.wav');

$prefix = date('Y-m');

$result = $upload->getPrefixFile($prefix);

if ($result == false) {
    echo "ERROR:<br />";
    dump($upload->errorMsg);
    die;
}

$files = [];

foreach ($result as $file){
    $files[] = $file['key'];
}

$result = $upload->buiBatchDelete($files);
dump($result);


