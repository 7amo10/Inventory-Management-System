<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier'); 

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('suppliers', 'email')->ignore($supplierId, 'uuid'), // Ignore the supplier's current email
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'shopname' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'account_holder' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
        ];
    }
}
