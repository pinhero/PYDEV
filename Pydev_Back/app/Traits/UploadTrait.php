<?php

namespace App\Traits;

trait UploadTrait
{
    public $public_path = "/public/Files/";
    public $storage_path = "/storage/Files/";

    public function file($file, $path): string
    {
        if ($file) {

            $extension       = $file->getClientOriginalExtension();
            $file_name       = $path . '-' .uniqid(). '.' . $extension;
            $url             = $file->storeAs($this->public_path, $file_name);

            $public_path     = public_path($this->storage_path . $file_name);
            
            $url             = preg_replace("/public/", "", $url);
            return  $url? $url: '';
        }
    }
}