<?php
namespace App\Controllers\Chat;
/**
 *
 */
use App\Plugins\Script\PHPInput;
class Interactive
{
    public static function send($chat='',$bot=null){
    	if(preg_match('/<?php/',$chat)){
    		$msg = PHPInput::set($chat);
    	}
    	if(isset($msg)):
    		return [
                	"text"         => $msg,
                	"chat_id"    => $bot->message->chat->id,
                	"parse_mode"=> "HTML",
                	"reply_to_message_id" => $bot->message->message_id
        	];
        endif;
    }
}
