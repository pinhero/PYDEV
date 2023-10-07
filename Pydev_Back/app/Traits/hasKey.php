<?php

namespace App\Traits;

trait HasKey
{
    public function hasKey($key)
    {
        return array_key_exists($key, $this);
    }
}
