<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePasswordRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'old_password' => 'required',
            'password' =>[
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'password_confirmation' => 'required|min:8|same:password'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'old_password.required' => __("Old password is required"),

            'password.required' => __("New password is required"),
            'password.string' => __("New password must be string"),
            'password.min' => __("New password must be at least 8 characters"),
            'password.strong_pass' => __("New password must be strong password"),
            'password.regex' => __("New password must be contain one lowercase letter, one uppercase letter and one digit"),
            
            'password_confirmation.required' => __("Confirmation password is required"),
            'password_confirmation.min' => __("Confirmation password must be at least 8 characters"),
            'password_confirmation.same' => __("Confirmation password must be same as new password"),
        ];
    }
}
