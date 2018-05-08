<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Url : PTP6.Com
 * Date: 2018/5/8
 * Time: 15:33
 */

namespace App\Controller;


use RookieVoice\Voice;

class Run extends Controller
{
    public function run()
    {

        echo $rootpath = str_replace('\\','/',realpath(dirname(__FILE__).'/'));die;

        $request = new Request();
        $string = $request->request();

        if (isset($string[0]) && is_null($string[0])) {
            return $this->putMsg(001,$string[1]);
        }

    }


    private function voice($text)
    {
        $voiceObject = new Voice();
    }

}