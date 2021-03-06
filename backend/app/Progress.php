<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = ['user_id', 'customer_id', 'status_id', 'body', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function status()
    {
        return $this->hasOne('App\Status', 'status_id', 'status_id');
    }
}
