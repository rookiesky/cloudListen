# 文字转语音类

- 语音接口使用的是讯飞开放平台

### 使用教程

````
$voice = new \RookieVoice\Voice();
$voice->appid = '';   //必填   讯飞后台查看
$voice->apiKey = ''; //必填  讯飞后台查看
$voice->isnum = 2;  //可选 生成语音条数
$voice->speed = 50;  //可选 语速，可选值：[0-100]，默认为50
$voice->volume = 50;  //可选 音量，可选值：[0-100]，默认为50
$voice->pitch = 50;  //可选 音高，可选值：[0-100]，默认为50
$voice->aue = raw;  // 可选 音频编码，可选值：raw（未压缩的pcm或wav格式），lame（mp3格式）

$result = $voice->getVoice($text);

$voice->suffix();  //获取音频后缀
$vocie->errorMsg;  //获取错误信息

````
