<?php
namespace App\Controllers;
/**
 *
 */
use App\Helper\Telegram;
use Config\Config;
class SetHooks
{
    public function index(){
        $telegram = Config::get('telegram');
        dd(Telegram::setwebhook(['url'=>$telegram['hooks']]));
    }
}
