<?php

namespace App\Models\Administrateur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteComment extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'comment','value'];
    public $timestamps = false;


}
