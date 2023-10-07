<?php

namespace App\Models\Administrateur;

use App\Models\Administrateur\TypeDocumentation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class Documentation extends Model
{
    use HasFactory;
    protected $fillable = ['type_documentation_id','libelle', 'documenten', 'documentfr', 'description'];
    protected $appends = ['document_en_url','document_fr_url'];
    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
        'updated_at' => 'datetime:d.m.Y',
    ];
    protected static function booted()
    {
        static::creating(function ($documentation) {
            $documentation->slug = Str::slug($documentation->libelle, '-');
        });
        static::updating(function ($documentation) {
            $documentation->slug = Str::slug($documentation->libelle, '-');
        });
    }
    public function type_documentation(): BelongsTo
    {
        return $this->belongsTo(TypeDocumentation::class);
    }

    public function getDocumentEnUrlAttribute()
    {
        return Storage::url('uploads/' . $this->documenten);
    }
    public function getDocumentFrUrlAttribute()
    {
        return Storage::url('uploads/' . $this->documentfr);
    }
    public function deleteFile($name)
    {
        if (Storage::delete("uploads/$name")) {
            return  response()->json(['message' => true]);
        }
        return response()->json(['message' => false]);
    }
}
