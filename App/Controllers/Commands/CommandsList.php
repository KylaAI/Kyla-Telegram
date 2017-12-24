<?php
namespace App\Controllers\Commands;

/**
 *
 */
use App\Plugins\Register\Register;
use App\Plugins\Check\CheckMember;
use \App\Controllers\Commands\Admin;
class CommandsList
{
    private static $method = [];
    private static $mainData = null;
    public function __construct($updateData){
        self::$mainData = $updateData;
        $class = new \ReflectionClass('\App\Controllers\Commands\CommandsList');
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $key) {
            $method[] = strtolower($key->name);
        }
        self::$method = $method;
    }
    public static function getCommand(){
        return self::$method;
    }
    public function test(){
        file_put_contents('get.json',json_encode([]));
        return [
            'chat_id'=>self::$mainData->message->chat->id,
            'text'=>'testing'
        ];
    }
    public function thanks(){
        file_put_contents('get.json',json_encode([]));
        return [
            'chat_id'=>self::$mainData->message->chat->id,
            'text'=>'Terima kasih :)'
        ];
    }
    public function listmember($messages){
        $s = '';
        $msg = Register::list(self::$mainData);
        return [
                "text"         => $msg,
                "chat_id"    => self::$mainData->message->chat->id,
                "parse_mode"=> "HTML",
                "reply_to_message_id" => self::$mainData->message->message_id
        ];
    }
    public function register($messages){
        $query = explode(' ',$messages,2);
        unset($query[0]);
        if($query){
            $query = implode(' ',$query);
            $user_data = explode(';',$query);
            $s = [];
            for ($i=0; $i < count($user_data); $i++) {
                $data = explode('=',$user_data[$i]);
                $key = str_replace('@','',$data[0]);
                $s = array_merge([$key=>$data[1]],$s);
            }
            $regist = Register::set($s,self::$mainData);
            $msg = 'Data kamu sudah di proses '.self::$mainData->message->from->first_name;
            if($regist){
                $msg = $regist;
            }
        }
        else {
            $msg = "Lakukan register data kamu untuk memudahkan pencarian jika sewaktu-waktu diperlukan.\nGunakan command sebagai berikut.\n/register @akun=isi \nNote : Gunakan tanda ; untuk pemisah.\nSemisal @github=ppabcd;@name=rezajuliandri";
        }
        return [
                "text"         => $msg,
                "chat_id"    => self::$mainData->message->chat->id,
                "parse_mode"=> "HTML",
                "reply_to_message_id" => self::$mainData->message->message_id
        ];
    }
    public function whois($messages){
        $query = explode(' ',$messages,2);
        unset($query[0]);
        if($query){
            $username = str_replace('@','',$query[1]);
            $check = CheckMember::set($username,self::$mainData);
            if($check){
                $msg = $check;
            }
        }
        else {
            $msg = "Gunakan command berikut ini untuk mengetahui info member. \n /whois @username\n";
        }
        return [
                "text"         => $msg,
                "chat_id"    => self::$mainData->message->chat->id,
                "parse_mode"=> "HTML",
                "reply_to_message_id" => self::$mainData->message->message_id
        ];
    }
    public function admin($messages){
        $query = explode(' ',$messages,2);
        unset($query[0]);
        if($query){
            $username = str_replace('@','',$query[1]);
            $check = Admin::set($username,self::$mainData);
            if($check){
                $msg = $check;
            }
        }
        else {
            $msg = 'Command ini hanya boleh digunakan oleh super admin saja';
        }
        return [
                "text"         => $msg,
                "chat_id"    => self::$mainData->message->chat->id,
                "parse_mode"=> "HTML",
                "reply_to_message_id" => self::$mainData->message->message_id
        ];
    }


    private function Keyboard(array $data){
        // Undermaintenance
    }

}
