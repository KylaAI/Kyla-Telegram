<?php
function dd($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function logs($data,$place){
    file_put_contents(BASEPATH.'//Log/'.$place.'.html',json_encode($data));
}
