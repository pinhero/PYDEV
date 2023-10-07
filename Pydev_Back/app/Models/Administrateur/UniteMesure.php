<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniteMesure extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'description'];

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
