<?php
namespace  App\Controllers;
/**
 *
 */

use Config\Config;

use App\Controllers\Commands\CommandsList;
use App\Helper\Crayner_Machine;
use App\Helper\Telegram;
use App\Controllers\Chat\Interactive;
use App\Controllers\Main\Group;
use App\Controllers\Main\Callback;

class Home
{
    public function index(){
        $input = self::getInput();
        $messages = (isset($input->message->text))?$input->message->text:null;

        logs($messages,'messaes');
        $conf = Config::get('telegram');

        $command = new CommandsList($input);

        $gC = $command::getCommand();
        $msg = explode(' ',str_replace($conf['username'],'',$messages));
        logs($msg,'messages');
        $cmd = str_replace('/','',$msg[0]);
        $cmd = str_replace(' ','_',$cmd);
        $res = [];
        Group::check($input);
        if(in_array($cmd,$gC)){
            $res = $command::{$cmd}($messages);
        }
        else if(isset($input->callback_query)){
            $res = Callback::get($input);
        }
        else {
            $res = Interactive::send($messages,$input);
        }
        logs($res,'Response');
        if(!isset($_GET['curl']))
        Telegram::sendMessage($res);
    }
    public static function getInput(){
        $input = json_decode(file_get_contents('php://input'));
        logs($input,'input');
        if(!isset($_GET['curl']))
        logs(Crayner_Machine::qurl(Config::get('telegram')['hooks'].'?curl','',file_get_contents('php://input')),'output');
        return $input;
    }
    public function messages($id,$text,$reply=null){
        $res = [
            'chat_id'=>$id,
            'text'=>urldecode($text),
            "reply_to_message_id" => $reply
        ];
        Telegram::sendMessage($res);
    }
}
