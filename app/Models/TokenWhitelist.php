<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenWhitelist extends Model
{
    protected $table = 'token_whitelists';

    protected $fillable = [
        'user_id', 'token', 'user_agent',
        'ip_address', 'expired_at',
    ];

    public $timestamps = true;
}