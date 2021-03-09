<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => 'max:50',
            'min_age' => 'integer|between:0,120',
            'max_age' => 'integer|between:0,120',
        ];
    }

    public function messages()
    {
        return [
            'search.max' => 'キーワードは50文字以内で入力してください',
            'min_age.integer' => '年齢は数字で入力してください',
            'min_age.between' => '年齢は０~120歳で入力してください',
            'max_age.integer' => '年齢は数字で入力してください',
            'max_age.between' => '年齢は０~120歳で入力してください',
        ];
    }
}
