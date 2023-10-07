<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieMarchandise extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($categorieMarchandise) {
            $categorieMarchandise->slug = Str::slug($categorieMarchandise->libelle, '-');
        });
        static::updating(function ($categorieMarchandise) {
            $categorieMarchandise->slug = Str::slug($categorieMarchandise->libelle, '-');
        });
    }

    public function marchandises(): HasMany
    {
        return $this->hasMany(Marchandise::class);
    }
}
