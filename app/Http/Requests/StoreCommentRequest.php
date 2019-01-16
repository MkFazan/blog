<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'text' => 'required|string|max:500',
            'parent_id' => 'integer|exists:comments,id|nullable|min:1|max:' . config('app.primary_key_max_value'),
            'article_id' => 'integer|exists:articles,id|min:1|max:' . config('app.primary_key_max_value'),
            'status' => 'integer|nullable',
        ];
    }
}
