<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BioRequest extends FormRequest
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
            'bio' => trans('ocv.bio_and_about_me'),
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
            'bio' => 'required|min:10|max:1500'
        ];
    }
}
