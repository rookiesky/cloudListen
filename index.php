<?php
require './vendor/autoload.php';
require './common/function.php';

define('DEBUG',true);    //是否开启调试模式TRUE开启，反之关闭
define('ROOT_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/')));

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $optionTitle = "框架出错了";
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($optionTitle);
    $whoops->pushHandler($option);
    $whoops->register();
    //ini_set('display_errors','on');
}
//加载获取ENV配置
$dotenv = new \Dotenv\Dotenv('./');
$dotenv->load();


$star = new \App\Controller\Run();
$star->run();