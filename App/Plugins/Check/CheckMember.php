<?php
namespace App\Plugins\Check;
/**
 *
 */
 use App\Helper\DB;
class CheckMember
{
    public static function set(String $data,$bot){
        $cari = str_replace('@','',strtolower($data));
        $sql = "SELECT * FROM users_data WHERE username = :username";
        if(($bot->message->chat->type == "supergroup") || ($bot->message->chat->type == "group")):
            $sql .= " AND group_id=:group";
            $s[':group'] = $bot->message->chat->id;
        endif;
        $s[':username']= $cari;
        var_dump($s);
        $prep = DB::prepare($sql);
        $prep->execute($s);
        if($prep->rowCount() == 0){
            return "Tidak ada data yang tersedia dengan username @".$cari." silahkan meminta @".$cari." untuk mendaftarkan diri";
        }
        $out = $prep->fetch(\PDO::FETCH_OBJ);

        $data_user = json_decode($out->user_data,true);
        $str_data = '';
        foreach($data_user as $key=>$val){
            $key = str_replace('name','Nama',$key);
            $key = str_replace('from','Asal',$key);
            $str_data .= ucfirst($key)." : ".$val."\n";
        }
        return "Berikut adalah data user dari username @".$cari."\n".$str_data;
    }
}
