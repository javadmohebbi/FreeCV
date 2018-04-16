<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewExperience extends FormRequest
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
            'name' => trans('ocv.name'),
            'from_month' => trans('ocv.from_month'),
            'from_year' => trans('ocv.from_year'),
            'to_month' => trans('ocv.to_month'),
            'to_year' => trans('ocv.to_year'),
            'link' => trans('ocv.link'),
            'description' => trans('ocv.description'),
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
            'name' => 'required|min:1|max:50',
            'from_month' => 'required|min:1|max:12',
            'from_year' => 'required|numeric',
            'to_month' => 'required|min:1|max:12',
            'to_year' => 'required|numeric',
            'link' => 'url|max:255',
            'description' => 'required|min:10|max:1000',
        ];
    }
}
