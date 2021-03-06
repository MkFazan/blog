<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteImageRequest extends FormRequest
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
            'article_id' => 'required|integer|exists:article_images,article_id|min:1|max:' . config('app.primary_key_max_value'),
            'image_id' => 'required|integer|exists:article_images,image_id|min:1|max:' . config('app.primary_key_max_value'),
        ];
    }
}
