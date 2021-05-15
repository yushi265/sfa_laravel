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

    public static function getSearchQuery($request)
    {
        $query = Progress::query();
        $search = $request->search;
        $status = $request->status;

        if ($request->filled('status')) {
            $query->where(function ($query) use ($status) {
                $query->where('status_id', $status);
            });
        }

        if ($request->filled('search')) {
            $query
                ->where('body', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        return $query;
    }
}
