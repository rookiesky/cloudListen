# 中文转音频

 - 可以单独转一条音频或多条音频
 
### 使用

````
$voice->setTokenInfo($appkey,$appserct);
$voice->num = 2;  //设置音频条数 可选填
$voice->spd = 5;    //语速 0-9 可选填
$voice->pit = 5;    //雨调 0-9 可选填
$voice->vol = 5;    //音量 0-9 可选填
$voice->per = 3;   //发音人 可选填
//转音频
$result = $voice->getVoice($text);
//多条音频
if (isset($result[0]) && !empty($result[1])) {
    echo "mp3 Infos:<hr />";
    foreach ($result as $key=>$val){
        echo 'mp3:' . setFile($val['voice']) . "<br />TEXT:" . $val['text'] . "<br />LENGTH:" . $val['length'] . "<br />";
    }
}else{
//单条音频
    echo "mp3 Info:<hr />";
    echo 'mp3:' . setFile($result['voice']) . "<br />TEXT:" . $result['text'] . "<br />LENGTH:" . $result['length'];
}
````