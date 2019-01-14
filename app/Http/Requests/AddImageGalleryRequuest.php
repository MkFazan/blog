<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddImageGalleryRequuest extends FormRequest
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
            'article' => 'required|integer|exists:articles,id|min:1|max:' . config('app.primary_key_max_value'),
            'file' => 'required|file|mimes:jpeg,jpg,png|max:' . config('app.max_file_size'),
        ];
    }
}
