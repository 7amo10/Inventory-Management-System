<?php

namespace App\Http\Requests\Purchase;

use App\Enums\PurchaseStatus;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $invoiceProducts
 */
class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



}
