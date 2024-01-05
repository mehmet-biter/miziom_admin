<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
            'name' => 'required|string|max:255',
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

    public function messages()
    {
        return [
            'name.required' => __("Name is required"),

            'phone.numeric' => __("Invalid phone number"),
            'phone.unique' => __("This phone number already exists"),

            'photo.required' => __("Photo is required"),
            'photo.image' => __("Invalid image file"),
            'photo.mimes' => __("Supported image file are jpeg,png,jpg"),
        ];
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
