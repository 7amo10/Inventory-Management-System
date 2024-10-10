<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Illuminate\Support\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Validation\Rules\Enum;

/**
 * @property mixed $pay
 */
class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid'                => 'unique:orders',
            'payment_type'        => 'string|required',
            'order_date'          => 'required|string',
            'pay'                 => 'numeric|required',
            'customer_id'         => 'required',
            'products'            => 'required|array',  // Array of products
            'products.*.id'       => 'required|exists:products,id', // Ensure each product exists
            'products.*.quantity' => 'required|integer|min:1',  // Product quantity must be at least 1
            'products.*.price'    => 'required|numeric|min:0',  // Price validation
            'subtotal'            => 'required|numeric|min:0',
            'vat'                 => 'required|numeric|min:0',  // VAT field
            'total'               => 'required|numeric|min:0',
        ];
    }

}
