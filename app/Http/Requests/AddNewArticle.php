<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewArticle extends FormRequest
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
    public function attributes()
    {
        return [
            'title' => trans('ocv.title'),
            'slug' => trans('ocv.slug'),
            'summary' => trans('ocv.summary'),
            'html_desc' => trans('ocv.description'),
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
            'title' => 'required|max:100|min:5',
            'slug' => 'required|max:200|unique:articles,slug',
            'summary' => 'required|min:5|max:1000',
            'html_desc' => 'required',
        ];
    }
}
