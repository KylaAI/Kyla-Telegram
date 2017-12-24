<?php
namespace App\Plugins\Script;
/**
* 
*/
use App\Helper\Crayner_Machine;
use App\Helper\Str;
use Config\Config;
class PHPInput
{
	public static function set($data){
		$tele = Config::get('telegram');
		$filename = date('YmdHis').Str::random(32).'.php';
		$data = explode('<?php',$data)[1];
		$except = [
			"apache_setenv",
			"apache_child_terminate",
			"define_syslog_variables",
			"escapeshellarg",
			"escapeshellcmd",
			"eval",
			"exec",
			"fp",
			"fput",
			"ftp_connect",
			"ftp_exec",
			"ftp_get",
			"ftp_login",
			"ftp_nb_fput",
			"ftp_put",
			"ftp_raw",
			"ftp_rawlist",
			"highlight_file",
			"ini_alter",
			"ini_get_all",
			"ini_restore",
			"inject_code",
			"mysql_pconnect",
			"openlog",
			"passthru",
			"php_uname",
			"phpAds_remoteInfo",
			"phpAds_XmlRpc",
			"phpAds_xmlrpcDecode",
			"phpAds_xmlrpcEncode",
			"popen",
			"posix_getpwuid",
			"posix_kill",
			"posix_mkfifo",
			"posix_setpgid",
			"posix_setsid",
			"posix_setuid",
			"posix_setuid",
			"posix_uname",
			"proc_close",
			"proc_get_status",
			"proc_nice",
			"proc_open",
			"proc_terminate",
			"shell_exec",
			"syslog",
			"system",
			"xmlrpc_entity_decode",
		];
		foreach($except as $e){
			$c = '/'.$e.'/';
			$check = preg_match($c,$data);
			if($check){
				echo $c;
				return "Tidak dapat menjalankan script karena terdapat code berbahaya.";
			}
		}
		$data = "<?php \n ini_set('memory_limit', '2M');\n".$data;
		file_put_contents(BASEPATH.'/Files/Script/'.$filename, $data);
		chmod(BASEPATH.'/Files/Script/'.$filename,444);
		$result = strip_tags(Crayner_Machine::qurl($tele['hooks'].'/Files/Script/'.$filename));
		$result = str_replace(BASEPATH.'/Files/Script/'.$filename,'',$result);
		if($result != ''){
            return "Hasil outputnya adalah: \n".$result;
		}
	}
}