<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        return [
            "name" => "required",
            "code" => ["required", Rule::unique('currency_lists')->ignore($this->id, 'id')],
            "symbol" => "required",
            "rate" => "required|numeric|gt:0"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => __("Currency name required"),
            "code.required" => __("Currency code required"),
            "symbol.required" => __("Currency symbol required"),
            "rate.required" => __("Currency rate required"),
            "rate.regx" => __("Currency rate not valid")
        ];
    }
}
