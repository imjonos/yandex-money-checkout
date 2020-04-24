<?php

namespace CodersStudio\YandexMoneyCheckout\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Exception
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'order_id' => 'required|numeric',
            'description' => 'required|string',
            'phone' => 'required|string',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.amount' => 'required|numeric',
            'items.*.vat_code' => 'required|numeric'
        ];
    }
}
