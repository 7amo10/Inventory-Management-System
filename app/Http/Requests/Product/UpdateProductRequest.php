<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            $productId = $this->route('product'); // Get the product UUID from the route

            return [
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:0',
                'buying_price' => 'required|integer|min:0',
                'selling_price' => 'required|integer|min:0',
                'quantity_alert' => 'required|integer|min:0',
                'tax' => 'nullable|integer|min:0',
                'tax_type' => 'nullable|integer|between:0,1',
                'notes' => 'nullable|string',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'unit_id' => 'required|exists:units,id',
            ];
        }
}
