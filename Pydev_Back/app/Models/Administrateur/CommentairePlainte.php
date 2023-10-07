<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Transporteur\Plainte;

class CommentairePlainte extends Model
{
    use HasFactory;
    protected $fillable = ['plainte_id','description'];

    protected static function booted()
    {
        // static::creating(function ($commentairePlainte) {
        //     $commentairePlainte->slug = Str::slug($commentairePlainte->libelle, '-');
        // });
        // static::updating(function ($commentairePlainte) {
        //     $commentairePlainte->slug = Str::slug($commentairePlainte->libelle, '-');
        // });
    }

    public function plainte(): BelongsTo
    {
        return $this->belongsTo(Plainte::class);
    }
}
