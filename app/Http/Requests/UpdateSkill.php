<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkill extends FormRequest
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

    public function attributes()
    {
        return [
            'skill' => trans('ocv.skill'),
            'color' => trans('ocv.color'),
            'percentage' => trans('ocv.percentage'),
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'skill' => 'required|min:1|max:50',
            'color' => 'required|min:1|max:5',
            'percentage' => 'required|numeric|min:1|max:100',
        ];
    }
}
