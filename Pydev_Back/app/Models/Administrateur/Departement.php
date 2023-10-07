<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    use HasFactory;
    protected $fillable = ['pays_id', 'name', 'code'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($departement) {
            $departement->slug = Str::slug($departement->name, '-');
        });
        static::updating(function ($departement) {
            $departement->slug = Str::slug($departement->name, '-');
        });
    }
    public function villes(): HasMany
    {
        return $this->hasMany(Ville::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Pays::class, 'pays_id');
    }

    
}
