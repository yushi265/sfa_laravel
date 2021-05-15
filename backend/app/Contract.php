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
}


/**
 * contract_typeについて
 * 02  普通預金
 * 03  定期預金
 * 04  融資
 */
