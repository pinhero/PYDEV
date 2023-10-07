<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfirmationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'callback_url', 'email', 'url', 'date_expiration', 'token', 'deja_utilise',
    ];

}
