<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSteamPurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'steam_item_id' => 'required|exists:steam_items,id',
            'quantity' => 'required|integer',
            'purchase_cost' => 'required|decimal:0,2',
            'transaction_date' => 'nullable|before:now'
        ];
    }
}
