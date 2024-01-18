<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IconSaveRequest extends FormRequest
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
            'title'         => 'required',
            // 'tag'           => 'required',
            'category_id'   => 'sometimes',
            'icon'          => 'mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => __("Title is required"),
            'tag.required'         => __("Tag is required"),
            'category_id.required' => __("Category is required"),
            'icon.mimes'           => __("Icon not support. Supported icons are 'jpeg,png,jpg'"),
            'icon.max'             => __("Icon max size is 2MB"),
        ];
    }
}
