<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
            'text' => 'required|string|max:500',
            'meta_title' => 'required|string|max:50',
            'meta_description' => 'required|string|max:150',
            'meta_keywords' => 'required|string|max:255',
            'status' => 'integer|nullable',
            'slug' => 'required|string|max:100|unique:pages,slug,' . $this->page->id,
        ];
    }
}
