<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pays extends Model
{
    use HasFactory;
    
    protected $fillable = ['country_code', 'country_name'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($pays) {
            $pays->slug = Str::slug($pays->country_name, '-');
        });
        static::updating(function ($pays) {
            $pays->slug = Str::slug($pays->country_name, '-');
        });
    }
    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }
}
