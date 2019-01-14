<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:50|min:6',
            'description' => 'required|string|max:500|min:6',
            'parent_id' => 'integer|nullable',
            'meta_title' => 'required|string|max:50|min:6',
            'meta_description' => 'required|max:150|min:6',
            'meta_keywords' => 'required|max:255|min:6',
        ];
    }
}
