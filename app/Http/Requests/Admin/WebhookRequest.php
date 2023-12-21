<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
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
        return [
            'coin_id' => 'required',
            'label' => 'required',
            'type' => 'required',
            'url' => 'required',
            'numConfirmations' => 'required|integer|gt:0',
            'allToken' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'coin_id.required' => __('Coin id is required'),

            'label.required' => __('Label is required'),

            'type.required' => __('Type is required'),

            'url.required' => __('Url is required'),

            'allToken.required' => __('Tokens is required'),

            'numConfirmations.required' => __('NumConfirmations is required'),
            'numConfirmations.integer' => __('NumConfirmations should be number'),
            'numConfirmations.gt' => __('NumConfirmations should greater than 0'),
        ];
    }
}
