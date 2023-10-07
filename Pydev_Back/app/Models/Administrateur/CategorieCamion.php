<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieCamion extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($categorieCamion) {
            $categorieCamion->slug = Str::slug($categorieCamion->name, '-');
        });
        static::updating(function ($categorieCamion) {
            $categorieCamion->slug = Str::slug($categorieCamion->name, '-');
        });
    }
    public function type_camions():HasMany
    {
        return $this->hasMany(TypeCamion::class);
    }
}
