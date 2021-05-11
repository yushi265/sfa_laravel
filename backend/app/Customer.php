<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $fillable = ['name', 'ruby', 'gender_id', 'birth', 'tel', 'address', 'mail', 'job_id', 'company'];

    public function progresses()
    {
        return $this->hasMany('App\Progress');
    }

    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    public function getAmountOfOrdinaryAttribute()
    {
        return $this->contracts()->where('contract_type_id', '2')->sum('amount');
    }

    public function getAmountOfTimeAttribute()
    {
        return $this->contracts()->where('contract_type_id', '6')->sum('amount');
    }

    public function getAmountOfLoanAttribute()
    {
        return $this->contracts()->where('contract_type_id', '9')->sum('amount');
    }

    public function gender()
    {
        return $this->hasOne('App\Gender', 'gender_id', 'gender_id');
    }

    public function job()
    {
        return $this->hasOne('App\Job', 'job_id', 'job_id');
    }

    /**
     * すべての顧客情報を取得
     * @return array $customers
     */
    public static function setAllCustomersAge($customers)
    {
        foreach ($customers as $customer) {
            $customer->age = self::getAge($customer->birth);
        }

        return $customers;
    }

    /**
     * 現在の年齢を取得
     * @param date $birth
     * @return int $age
     */
    public static function getAge($birth)
    {
        $birthday = strtotime($birth);

        $birth_year = (int)date("Y", $birthday);
        $birth_month = (int)date("m", $birthday);
        $birth_day = (int)date("d", $birthday);

        // 現在の年月日を取得
        $now_year = (int)date("Y");
        $now_month = (int)date("m");
        $now_day = (int)date("d");

        // 年齢を計算
        $age = $now_year - $birth_year;

        // 「月」「日」で年齢を調整
        if ($birth_month === $now_month) {

            if ($now_day < $birth_day) {
                $age--;
            }
        } elseif ($now_month < $birth_month) {
            $age--;
        }

        return $age;
    }

    /**
     * 提案を取得する
     * @param int $age
     * @param array $deposit_status
     * @return array $suggests
     */
    public static function getSuggests($customer, $family_members)
    {
        $suggests = [];
        // 年金
        if ($customer->age >= 60 && $customer->age <= 65) {
            $suggests[] = '年金が請求できる可能性があります。提案してみましょう！';
        }
        // 普通預金
        if ($customer->amount_of_ordinary > 5000000) {
            $suggests[] = '普通預金に残高があります。定期預金を推進してみましょう！';
        }
        if ($customer->amount_of_ordinary > 0 && $customer->amount_of_ordinary < 1000) {
            $suggests[] = '普通預金の残高が少なくなっています。フリーローンやカードローンを推進してみましょう！';
        }
        // 定期預金
        if ($customer->amount_of_time > 10000000) {
            $suggests[] = '大口預金先です。定期預金の満期管理に注意しましょう！';
        }
        // 融資
        if ($customer->job_id == 4) {
            $suggests[] = '学生です。奨学ローンが必要な可能性があります。ご親族にお会いしたら提案してみましょう！';
        }

        if ($customer->amount_of_loan > 500000) {
            if ($customer->job_id == 3) {
                $suggests[] = '融資先です。業況を確認して、積極的に支援しましょう！';
            } else {
                $suggests[] = '融資があります。';
            }
        } elseif ($customer->amount_of_loan <= 500000 && $customer->amount_of_loan > 0) {
            $suggests[] = '融資残高が少なくなってきました。リファイナンスを提案しましょう！';
        }

        //家族に学生がいるとき、奨学ローンを推進（学生自身は除く）
        if ($customer->job_id !== 4) {
            foreach ($family_members as $member) {
                if ($member->job_id == 4) {
                    $suggests[] = '家族に学生がいます。奨学ローンを提案してみましょう。';
                    break;
                }
            }
        }

        return $suggests;
    }
}
