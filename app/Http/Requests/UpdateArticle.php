<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Input;

class UpdateArticle extends FormRequest
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
        $id = Input::get('id');
        return [
            'id'                    => 'required|numeric',
            'title'                 => 'required|max:100|min:5',
            'slug'                  => 'required|max:200|unique:articles,slug,' .$id,
            'summary'               => 'required|min:5|max:1000',
            'html_desc'             => 'required',
            'image_id'              => 'numeric',
        ];
    }
}
