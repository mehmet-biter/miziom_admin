<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
        $rule = [
            'first_name' => 'required|string|max:255',
            'last_name' => ['required','string','max:255'],
            'email' => ['required','email',Rule::unique('users')->ignore(($this->edit_id),'id')],
        ];
        
        if($this->photo) {
            $rule['photo'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
        if($this->phone) {
            $rule['phone'] = ['numeric',Rule::unique('users')->ignore(($this->edit_id),'id')];
        }
        return $rule;
    }
}
