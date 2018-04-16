<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateDBRequest extends FormRequest
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
     * @return array
     */
    function attributes()
    {
        return [
            'db_host' => trans('ocv.installation_DB_HOST'),
            'db_port' => trans('ocv.installation_DB_PORT'),
            'db_name' => trans('ocv.installation_DB_DATABASE'),
            'db_usern' => trans('ocv.installation_DB_USERNAME'),
            'db_passn' => trans('ocv.installation_DB_PASSWORD'),
            'email' => trans('ocv.installation_USER_EMAIL'),
            'password' => trans('ocv.installation_USER_PASSWORD'),
            'password_confirmation' => trans('ocv.installation_USER_PASSWORD_CONFIRMATION'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'db_host' => 'required',
            'db_port' => 'required|numeric|min:1|max:65537',
            'db_name' => 'required',
            'db_usern' => 'required',
            'db_passn' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|max:14|confirmed',

        ];

//        dd($rule);

        return $rules;

    }
}

