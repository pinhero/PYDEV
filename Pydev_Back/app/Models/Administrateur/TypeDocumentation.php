<?php

namespace App\Models\Administrateur;

use App\Models\Administrateur\Documentation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeDocumentation extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($typeDocumentation) {
            $typeDocumentation->slug = Str::slug($typeDocumentation->libelle, '-');
        });
        static::updating(function ($typeDocumentation) {
            $typeDocumentation->slug = Str::slug($typeDocumentation->libelle, '-');
        });
    }
    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }

}
