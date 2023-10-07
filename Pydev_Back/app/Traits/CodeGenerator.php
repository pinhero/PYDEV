<?php


namespace App\Traits;


trait CodeGenerator
{
    /**
     * @param $prefix
     * @param $id
     * @return string
     */
    public function identifier($prefix, $id){
        $str = ''.$id;

        $len  = 5-strlen($str);

        for ($i = 0; $i < $len; $i++){
           $str =  '0'.$str;
        }
        return  $prefix.''.$str;
    }
}