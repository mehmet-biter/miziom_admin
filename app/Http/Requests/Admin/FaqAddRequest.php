<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqAddRequest extends FormRequest
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
            'question' => 'required|string|max:255',
            'answer' => ['required','string'],
            'status' => 'required'
        ];
        
        if($this->serial) {
            $rule['serial'] = ['integer','gte:0',Rule::unique('faqs')->ignore(($this->edit_id),'unique_code')];
        }
        return $rule;
    }
}
