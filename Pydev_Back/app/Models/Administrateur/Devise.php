<?php

namespace App\Models\Administrateur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Devise extends Model
{
    use HasFactory;

    protected $fillable = [ 'libelle', 'description'  ];
    
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($devise) {
            $devise->slug = Str::slug($devise->libelle, '-');
        });
        static::updating(function ($devise) {
            $devise->slug = Str::slug($devise->libelle, '-');
        });
    }
    
}
