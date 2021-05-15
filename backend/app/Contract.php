<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['user_id', 'customer_id', 'contract_type_id', 'amount', 'due_date', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function contract_type()
    {
        return $this->hasOne('App\Contract_type', 'contract_type_id', 'contract_type_id');
    }

    /**
     * 預金種別合計を取得
     * @param int $id
     * @return array $status
     */
    public static function getDepositStatus($id)
    {
        $status = [];
        $status['ordinary'] = self::where('customer_id', $id)->where('contract_type_id', 2)->sum('amount');
        $status['time'] = self::where('customer_id', $id)->where('contract_type_id', 6)->sum('amount');
        $status['loan'] = self::where('customer_id', $id)->where('contract_type_id', 9)->sum('amount');

        return $status;
    }

    public static function getSearchQuery($request)
    {
        $query = Contract::query();
        $search = $request->input('search');
        $contract_type_id = $request->input('contract_type_id');

        if ($request->filled('contract_type_id')) {
            $query->where(function ($query) use ($contract_type_id) {
                $query->where('contract_type_id', $contract_type_id);
            });
        }

        if ($request->filled('search')) {
            $query
                ->whereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        return $query;
    }
}


/**
 * contract_typeについて
 * 02  普通預金
 * 03  定期預金
 * 04  融資
 */
