<?php
require './vendor/autoload.php';

$voice = new \Rookie\Voice\Voice();

$appkey = '';
$appserct = '';


$text = "覃天卫强调，各级关工委要深刻领会习近平新时代中国特色社会主义思想和党的十九大精神，打牢新时代关心下一代的思想理论根基，立足新时代坐标思考谋划工作，聚焦新时代任务把准工作方向，根据新时代要求明确建设方向。要坚持以新思想为统领，奋力开创新时代全市关心下一代工作的工作局面，着眼于习近平新时代中国特色社会主义思想这一主线和灵魂，将其贯彻到新时代关心下一代工作全过程;着眼于党对青年一代的殷切期望，进一步激发广大“五老”投身关心下一代事业的积极性和热情;着眼于对我国社会主要矛盾做出的新判断，进一步提高服务青少年的质量和水平;着眼于两个一百奋斗目标的总要求，进一步凝聚起培养合格建设者和可靠接班人的“正能量”。要切实加强关工委建设，不断提高做好关心下一代工作的专业化水平，坚持以深入有效的调查研究推动工作创新发展，不断提升基层组织建设的质量和水平，不断提高工作队伍的素质和能力，为加快实现“两个建成”、谱写新时代玉林发展新篇章再立新功、再创佳绩。";

$text .= 'W同学在上海上的学，毕业的时候直接进入了外企，当时大多书人还没有年薪的概念、实习的时候只有800元，可是人家就已经随随便便拿到了二三十万年薪，后来又在上海遇到了现在的爱人，央企、海归还比他小四五岁，新婚甜蜜。L同学回家创业，做的是文化传媒，两三年就已经有了3家公司，手下光员工就几十号，每天开着豪车到处商务谈判接业务。进入体制内的F同学，这几年也在仕途上走的顺风顺水，短短几年就已经称为某局委的科级干部，买了两套房，计划着生二娃。Z同学当时在班里很文静不起眼，现在成为自由职业者，做培训月入5万+，时间还很自由，没事儿就去国外旅游，朋友圈到处都是异域风光，这两年还健身练出了马甲线，兼职模特，成了当地的知名网红。';


$voice->setTokenInfo($appkey,$appserct);
$voice->num = 2;
$result = $voice->getVoice($text);

if (current($result) === null) {
    var_dump("ERROR:" . $result);
}



if (isset($result[0]) && !empty($result[1])) {
    echo "mp3 Infos:<hr />";
    foreach ($result as $key=>$val){
        echo 'mp3:' . setFile($val['voice']) . "<br />TEXT:" . $val['text'] . "<br />LENGTH:" . $val['length'] . "<br />";
    }
}else{
    echo "mp3 Info:<hr />";
    echo 'mp3:' . setFile($result['voice']) . "<br />TEXT:" . $result['text'] . "<br />LENGTH:" . $result['length'];
}




function setFile($data)
{
    $filename = './' . microtime() . '.mp3';
    file_put_contents($filename,$data);
    return $filename;
}