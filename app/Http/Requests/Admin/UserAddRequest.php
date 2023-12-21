<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAddRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore(($this->edit_id),'id')],
            'role' => 'required|exists:roles,id'
        ];
        if(empty($this->edit_id)) {
            $rule['password'] = ['required','min:8','max:255'];  
        }
        if (!empty($this->password)) {
            $rule['password_confirmation'] = 'required|min:8|same:password';
        }
        if($this->photo) {
            $rule['photo'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
        if($this->phone) {
            $rule['phone'] = ['numeric',Rule::unique('users')->ignore(($this->edit_id),'id')];
        }
        
        return $rule;
    }
}
