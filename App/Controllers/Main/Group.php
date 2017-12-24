<?php
namespace App\Controllers\Main;
/**
 *
 */
use App\Helper\DB;
class Group
{
    public static function check($bot){
        if(isset($bot->message->chat)){
            if(($bot->message->chat->type == "supergroup") || ($bot->message->chat->type == "group")){
                $group[':username'] = '';
                $group[':type'] = $bot->message->chat->type;
                if($bot->message->chat->type == "supergroup"){
                    $group[':username'] = (isset($bot->message->chat->username))? $bot->message->chat->username : '';
                }
                $group[':title'] = $bot->message->chat->title;
                $group[':group_id'] = $bot->message->chat->id;
                $sql = "SELECT * FROM group_detail WHERE group_id = :group";
                $query = DB::prepare($sql);
                $query->execute([':group'=>$bot->message->chat->id]);
                if($query->rowCount() == 0){
                    $sql = "INSERT INTO group_detail (group_id, username, title, type) VALUES (:group_id, :username, :title, :type);";
                    $query = DB::prepare($sql);
                    $query->execute($group);
                }
                return true;
            }
        }
    }
}
