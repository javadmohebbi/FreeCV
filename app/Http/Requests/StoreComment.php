<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComment extends FormRequest
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
            'email' => trans('ocv.email'),
            'comments' => trans('ocv.comment'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!\Auth::check())
            return [
                'name' => 'required|max:50',
                'email' => 'required|email|max:255',
                'comments' => 'required|max:1000',
            ];
        else {
            return [
                'comments' => 'required|max:1000',
            ];
        }
    }
}
