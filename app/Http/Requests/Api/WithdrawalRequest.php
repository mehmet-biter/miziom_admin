<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class WithdrawalRequest extends FormRequest
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
            'address' => ['string'],
            'wallet_id' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric' //|min:' . $this->minimum_withdrawal . '|max:' . $this->maximum_withdrawal
        ];
    }

    public function messages()
    {
        $msg = [
            'address.required' => __('Address is required'),
            'address.string' => __('Address must be a string!'),
            'amount.required' => __('Coin type is required'),
            'amount.numeric' => __('Amount must be numeric field!'),
            'code.required' => __('Code is required'),
            'code_type.required' => __('Code Type is required'),
            'wallet_id.required' => __('Wallet is required'),
        ];
        if (!empty($this->message)) {
            $msg['note.string'] = __('Message must be a string');
        }

        return $msg;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $errors = [];
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
            }
            $json = [
                'success'=>false,
                'message' => $errors[0],
            ];
            $response = new JsonResponse($json, 200);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
