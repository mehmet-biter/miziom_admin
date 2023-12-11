<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'mobile' => 'required|max:255',
            'subject' => 'required|max:255',
            'description' => 'required',
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.required' => __("Email address can't empty"),
            'password.required' => __("Password can't empty"),
            'email.email' => __('Invalid email address.'),
            'email.exists' => __('Invalid email address.'),
        ];
    }
}
