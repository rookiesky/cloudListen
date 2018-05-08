<?php
require "./vendor/autoload.php";

define('DEBUG',true);

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $optionTitle = "框架出错了";
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($optionTitle);
    $whoops->pushHandler($option);
    $whoops->register();
    ini_set('display_errors','on');
}


$str = '原来的我可以穿漂亮的白裙子，画着淡淡的妆，当婉转的《茉莉花》音乐响起我在舞台中央翩翩起舞，仿佛整个世界上只有我一个人。舞蹈队里的姐妹们都说我就像一朵美丽茉莉花，也只有我能够把那支舞蹈演绎的那么优雅动人。那时候的我是有多么的骄傲，我活在一个充满鲜花和掌声的世界里，而且我还有一个非常爱我的男朋友，让我觉得我所有的付出都是值得。他每天都像公主一样宠着我，任我撒娇淘气，无理取闹。每次我训练完舞蹈，他都会骑着单车来我训练的地方接我。坐在他骑着的单车上，环着他的腰把脸贴在他的背上，听他均匀的心跳声，我感到无比的踏实。夕阳照在我们身上，在地上留下一道长长的影子。我的头发随着风飞扬舞动，像我在舞台上一样轻盈，还有我长长的白裙子,我依偎在他的怀里，他把下巴轻轻地放在我的头顶，给我讲他在工作中遇到的有趣的人和有趣的事，每次都把我逗得咯咯直笑。我们还曾一起设想我们的未来，他说他会努力工作，等他攒够了钱就买一幢大房子和我结婚，然后我们生一个女儿或儿子，每天喊他爸爸，叫我妈妈，一家三口幸福的生活下去。我说我喜欢儿子，他说他喜欢女儿。我说儿子知道和妈妈亲。他说女儿是爸爸的贴心小棉袄，而且要像我一样漂亮，这样家里就有两个小公主了。我不依的在他的怀里撒娇，他最后只好妥协，坏坏的说那就要一个像他一样帅的儿子。我抬起头看了一眼他干净的脸庞，笑着说一定要比他帅才行，接着又把头埋进他的怀里。他把我抱的更紧，我感觉我就是这世界上最幸福的人';

$voice = new \RookieVoice\Voice();
$voice->appid = '';
$voice->apiKey = '';
$voice->isnum = 2;
$result = $voice->getVoice($str);


if ($voice->errorMsg) {
    dump($voice->errorMsg);
}

$suffix = $voice->suffix();

if (is_string($result)) {
    save(time() . $suffix,$result);
}

if (is_array($result)) {
    foreach ($result as $key=>$vo){
        save(time() . '_' .$key .$suffix,$vo);
    }
}


function save($fileName,$data)
{
    file_put_contents($fileName,$data);
}
