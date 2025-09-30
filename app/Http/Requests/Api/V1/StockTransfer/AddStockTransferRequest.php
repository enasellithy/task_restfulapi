<?php

namespace App\Http\Requests\Api\V1\StockTransfer;

use App\Models\Stock;
use App\Solid\Traits\JsonTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddStockTransferRequest extends FormRequest
{
    use JsonTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from_warehouse_id' => [
                'required',
                'exists:warehouses,id',
                function ($attribute, $value, $fail) {
                    $stock = Stock::where('warehouse_id', $value)
                        ->where('inventory_item_id', $this->inventory_item_id)
                        ->first();
                    if (!$stock) {
                        $fail('No quantity Available in warehouse');
                        return;
                    }

                    if ($this->quantity && $stock->quantity < $this->quantity) {
                        $fail("quantity required ({$this->quantity}) not available in warehouse");
                    }
                }
            ],
            'to_warehouse_id'   => 'required|exists:warehouses,id|different:from_warehouse_id',
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity'          => 'required|integer|min:1',
            'notes'             => 'nullable|string',
        ];
    }

    public function getSourceStock()
    {
        return Stock::where('warehouse_id', $this->from_warehouse_id)
            ->where('inventory_item_id', $this->inventory_item_id)
            ->first();
    }

    protected function failedValidation(Validator $validator)
    {
        $err = $validator->errors()->first();
        throw new HttpResponseException($this->whenError($err));
    }
}
