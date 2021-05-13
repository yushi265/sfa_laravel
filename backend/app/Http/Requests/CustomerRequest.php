<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getValidatorInstance()
    {
        $birth = $this->birth;
        $birth = implode('-', $birth);
        $this->merge([
            'birth' => $birth,
        ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:30',
            'ruby' => 'required|max:30',
            'gender_id' => 'required',
            'birth' => 'required|date|before_or_equal:"now"',
            'tel' => 'required|regex:/^[0-9\-]+$/i|digits_between:1,11',
            'address' => 'required',
            'mail' => '',
            'job_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は30文字以内で入力してください',
            'ruby.required' => 'フリガナを入力してください',
            'ruby.max' => 'フリガナは30文字以内で入力してください',
            'gender.required'  => '性別を選択してください',
            'birth.required' => '生年月日を入力してください',
            'birth.before_or_equal' => '生年月日を確認してください',
            'birth.date' => '正しい生年月日を入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.digits_between' => '電話番号は11文字以内で入力してください',
            'tel.regex' => '電話番号は数字で入力してください',
            'address.required' => '住所を入力してください',
            'mail.email' => 'メールアドレスを正しい形式で入力してください',
            'job.required' => '職業を選択してください',
        ];
    }
}
