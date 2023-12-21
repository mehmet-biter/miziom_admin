<?php

namespace App\Http\Requests\Admin;

use App\Models\Coin;
use Illuminate\Foundation\Http\FormRequest;

class CoinSettingRequest extends FormRequest
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
            'coin_id' => 'required'
        ];
        if(isset($this->coin_id)) {
            $coin = Coin::find(decrypt($this->coin_id));
            if($coin) {
                if ($coin->network == BITGO_API) {
                    $rules['bitgo_wallet_id'] = 'required|max:255';
                    $rules['bitgo_wallet'] = 'required|max:255';
                    $rules['chain'] = 'required|integer';
                }
            }
        }

        return $rules;
    }
}
