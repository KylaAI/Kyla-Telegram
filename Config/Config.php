<?php
namespace Config;


class Config
{
    public static function get($str){
        return require(BASEPATH.'//Config/'.ucfirst($str).'.php');
    }
}
