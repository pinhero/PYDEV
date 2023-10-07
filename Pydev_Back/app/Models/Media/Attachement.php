<?php

namespace App\Models\Media;

use App\Models\Administrateur\DocumentType;
use App\Models\User;
use App\Models\Expertise\Expert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attachement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'numero_piece',
        'status',
        'date_expiration',
        'image',
        'commentaire',
        'document_type',
    ];
    protected $appends = ['image_url'];

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class,'experts','user_id');
    }
    protected $casts = [
        'date_expiration' => 'datetime:d-m-Y',
    ];
    public function getImageUrlAttribute()
    {
        return Storage::url('uploads/' . $this->image);
    }
    // "https://bdfret-api.mameribj.org".
}
