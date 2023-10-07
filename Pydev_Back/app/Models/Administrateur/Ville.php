<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [ 'departement_id', 'name'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($ville) {
            $ville->slug = Str::slug($ville->name, '-');
        });
        static::updating(function ($ville) {
            $ville->slug = Str::slug($ville->name, '-');
        });
    }
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
