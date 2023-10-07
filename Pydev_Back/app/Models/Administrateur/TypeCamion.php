<?php

namespace App\Models\Administrateur;

use App\Models\Transporteur\MoyenTransport;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeCamion extends Model
{
    use HasFactory;
    protected $fillable = ['categorie_camion_id','libelle', 'description'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($typeCamion) {
            $typeCamion->slug = Str::slug($typeCamion->libelle, '-');
        });
        static::updating(function ($typeCamion) {
            $typeCamion->slug = Str::slug($typeCamion->libelle, '-');
        });
    }

    public function categorie_camion(): BelongsTo
    {
        return $this->belongsTo(CategorieCamion::class);
    }
    public function moyen_transports(): HasMany
    {
        return $this->hasMany(MoyenTransport::class);
    }
}
