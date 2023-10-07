<?php

namespace App\Models\Administrateur;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($documentType) {
            $documentType->slug = Str::slug($documentType->name, '-');
        });
        static::updating(function ($documentType) {
            $documentType->slug = Str::slug($documentType->name, '-');
        });
    }

    
}
