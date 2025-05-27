<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:250'
            ],
            'content' => 'required|string|min:10|max:4000',
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,avif,jpg,gif,svg,webp|max:2048',
        ];
    }
}
