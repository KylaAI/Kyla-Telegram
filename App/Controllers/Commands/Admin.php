<?php
namespace App\Controllers\Commands;
/**
 *
 */
use App\Helper\DB;
use Config\Config;
class Admin
{
    public static function set(String $data,$bot){
        $data = str_replace('@','',strtolower($data));
        $Super = Config::get('user')['id_user'];
        if($Super == $bot->message->chat->id){
            $sql = "SELECT * FROM users_admin WHERE username = :username AND group_id=:group";
            $query = DB::prepare($sql);
            $query->execute([':username'=>$data,':group'=>$bot->message->chat->id]);
            if($query->rowCount() != 0){
                return "@".$data." Sudah menjadi admin";
            }
            $sql = "INSERT INTO users_admin(username, group_id, created_at, updated_at)
                    VALUES (:user,:group,:created,:updated)";
            $query = DB::prepare($sql);
            $query->execute([
                ':user'=>$data,
                ':group'=>'',
                ':created'=>date('Y-m-d H:i:s'),
                ':updated'=>date('Y-m-d H:i:s')
            ]);
            return "@".$data." sekarang adalah admin bot ini";
        }
        else {
            return "Kamu tidak memiliki akses untuk ke command ini";
        }
    }
}
