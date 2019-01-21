<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            "name" => "nullable|string|max:50",
            "description" => "nullable|string|max:50",
            "meta_title" => "nullable",
            "meta_description" => "nullable|string|max:50",
            "meta_keywords" => "nullable|string|max:50",
            "author_name" => "nullable|string|max:50",
            "categories" => 'array|nullable',
            'categories.*' => 'integer|exists:categories,id|max:' . config('app.max_file_size'),
        ];
    }
}
