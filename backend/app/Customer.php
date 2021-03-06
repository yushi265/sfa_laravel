<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;

class Customer extends Model
{
    protected $fillable = ['name', 'ruby', 'gender_id', 'birth', 'tel', 'address', 'mail', 'job_id', 'company'];

    // リレーション
    public function progresses()
    {
        return $this->hasMany('App\Progress');
    }

    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    public function gender()
    {
        return $this->hasOne('App\Gender', 'gender_id', 'gender_id');
    }

    public function job()
    {
        return $this->hasOne('App\Job', 'job_id', 'job_id');
    }

    // アクセサ
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

    /**
     * 現在の年齢を取得
     * @param date $birth
     * @return int $age
     */
    public function getAgeAttribute()
    {
        $birthday = strtotime($this->birth);

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

        return $this->age = $age;
    }

    public function getFamilyMembersAttribute()
    {
        $query = $this->query();
        $family_members = $query
            ->whereNotIn('id', [$this->id])
            ->where('tel', $this->tel)
            ->with('gender', 'job')
            ->get();

        return $this->family_members = $family_members;
    }

    /**
     * 提案を取得する
     * @param int $age
     * @param array $deposit_status
     * @return array $suggests
     */
    public function getSuggestsAttribute()
    {
        $suggests = [];
        $student_job = Job::where('name', '学生')->first();
        $self_employed = Job::where('name', '自営業')->first();

        // 年金
        if ($this->age >= 60 && $this->age <= 65) {
            $suggests[] = '年金が請求できる可能性があります。提案してみましょう！';
        }

        // 普通預金
        if ($this->amount_of_ordinary > 5000000) {
            $suggests[] = '普通預金に残高があります。定期預金を推進してみましょう！';
        }
        if ($this->amount_of_ordinary > 0 && $this->amount_of_ordinary < 1000) {
            $suggests[] = '普通預金の残高が少なくなっています。フリーローンやカードローンを推進してみましょう！';
        }

        // 定期預金
        if ($this->amount_of_time > 10000000) {
            $suggests[] = '大口預金先です。定期預金の満期管理に注意しましょう！';
        }

        // 融資
        if ($this->job_id == $student_job->id) {
            $suggests[] = '学生です。奨学ローンが必要な可能性があります。ご親族にお会いしたら提案してみましょう！';
        }
        if ($this->amount_of_loan > 500000) {
            if ($this->job_id == $self_employed->id) {
                $suggests[] = '融資先です。業況を確認して、積極的に支援しましょう！';
            } else {
                $suggests[] = '融資があります。';
            }
        } elseif ($this->amount_of_loan <= 500000 && $this->amount_of_loan > 0) {
            $suggests[] = '融資残高が少なくなってきました。リファイナンスを提案しましょう！';
        }

        //家族に学生がいるとき、奨学ローンを推進（学生自身は除く）
        if ($this->job_id !== $student_job->id) {
            foreach ($this->family_members as $member) {
                if ($member->job_id == $student_job->id) {
                    $suggests[] = '家族に学生がいます。奨学ローンを提案してみましょう。';
                    break;
                }
            }
        }

        return $this->suggests = $suggests;
    }

    public function explodeBirth()
    {
        list($registered_birth['year'], $registered_birth['month'], $registered_birth['day']) = explode("-", $this->birth);

        $this->birth = $registered_birth;
    }

    public static function setSearchQuery($request)
    {
        $search = $request->search;
        $gender_opt = $request->gender_opt;
        $job_opt = $request->job_opt;

        $query = Customer::query();

        if ($request->filled('gender_opt')) {
            $query->where('gender_id', $gender_opt);
        };

        if ($request->filled('job_opt')) {
            $query->where('job_id', $job_opt);
        };

        if ($request->filled('min_age')) {
            $min_birth = date("Y-m-d", strtotime("-" . $request->min_age . " year"));
            $query->where('birth', '<=', $min_birth);
        }

        if ($request->filled('max_age')) {
            $max_birth = date("Y-m-d", strtotime("-" . $request->max_age + 1 . " year"));
            $query->where('birth', '>', $max_birth);
        }

        $query->where(function ($query) use ($search) {
            $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('ruby', 'like', '%' . $search . '%')
                ->orWhere('tel', $search)
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%');
        });

        return $query;
    }
}
