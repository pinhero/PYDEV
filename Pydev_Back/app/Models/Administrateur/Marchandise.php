<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marchandise extends Model
{
    use HasFactory;
    protected $fillable = ['categorie_marchandise_id','name', 'description', 'poids'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($marchandise) {
            $marchandise->slug = Str::slug($marchandise->name, '-');
        });
        static::updating(function ($marchandise) {
            $marchandise->slug = Str::slug($marchandise->name, '-');
        });
    }
    public function categorie_marchandise(): BelongsTo
    {
        return $this->belongsTo(CategorieMarchandise::class);
    }
}
