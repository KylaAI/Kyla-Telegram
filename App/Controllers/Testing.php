<?php
namespace  App\Controllers;
/**
* 
*/
use App\Helper\Str;
use App\Helper\Crayner_Machine;
use Config\Config;
class Testing
{
	public function index(){
		$tele = Config::get('telegram');
		$filename = date('YmdHis').Str::random(32).'.php';
		$str= "<?php \n ini_set('memory_limit', '2M');\n\n\$nama = \"Reza Juliandri\"\nif(\$nama){\n echo \$nama;\n}";
		file_put_contents(BASEPATH.'/Files/Script/'.$filename, $str);
		$result = strip_tags(Crayner_Machine::qurl($tele['hooks'].'/Files/Script/'.$filename));
		$result = str_replace(BASEPATH.'/Files/Script/'.$filename,'',$result);
		echo "Hasil outputnya adalah: \n".$result;
	}
}