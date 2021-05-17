<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actlog extends Model
{
    protected $fillable = [
        'user_id',
        'route',
        'url',
        'method',
        'status',
        'message',
        'remote_addr',
        'user_agent',
    ];
}
