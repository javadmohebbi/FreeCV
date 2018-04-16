<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'email' => trans('ocv.email'),
            'tell' => trans('ocv.tell'),
            'fb' => trans('ocv.facebook'),
            'tw' => trans('ocv.twitter'),
            'yt' => trans('ocv.youtube'),
            'ig' => trans('ocv.instagram'),
            'li' => trans('ocv.linkedin'),
            'gh' => trans('ocv.googleplus'),
            'tg' => trans('ocv.telegram'),
            'gp' => trans('ocv.googleplus'),
            'pn' => trans('ocv.pinterest'),
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
            'email' => 'email|min:0|max:255',
            'tell' => 'max:50',
            'fb' => 'url|max:255',
            'tw' => 'url|max:255',
            'yt' => 'url|max:255',
            'ig' => 'url|max:255',
            'li' => 'url|max:255',
            'gh' => 'url|max:255',
            'tg' => 'url|max:255',
            'gp' => 'url|max:255',
            'pn' => 'url|max:255',
        ];
    }
}
