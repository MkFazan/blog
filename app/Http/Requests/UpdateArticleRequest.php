<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'meta_title' => 'required|string|max:50',
            'meta_description' => 'required|max:150',
            'meta_keywords' => 'required|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'integer|exists:categories,id|max:' . config('app.max_file_size'),
            'logo' => 'file|mimes:jpeg,jpg,png|max:' . config('app.max_file_size'),
            'status' => 'integer|nullable',
            'public' => 'integer|nullable',
        ];
    }
}
