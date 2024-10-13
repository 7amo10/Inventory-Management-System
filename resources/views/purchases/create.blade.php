@extends('layouts.tabler')

@section('title', 'Create Purchase')

@section('content')
<div class="page-body">
    <div class="container-xl">

        <x-alert />

        <div class="row row-cards">
            <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">{{ __('Create Purchase') }}</h3>
                                </div>
                                <div class="card-actions btn-actions">
                                    <a href="{{ route('purchases.index') }}" class="btn-action">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18 6l-12 12"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-4">
                                        <label for="date" class="form-label required">{{ __('Purchase Date') }}</label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ old('date') ?? now()->format('Y-m-d') }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="supplier_id" class="form-label required">Supplier</label>
                                        <select name="supplier_id" class="form-select" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="reference" class="form-label required">Reference</label>
                                        <input type="text" name="reference" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row gx-3 mb-3">

                                    <div class="col-md-12">
                                        <label for="tax_rate" class="form-label required">Tax Rate (%)</label>
                                        <input type="number" name="tax_rate" class="form-control" required min="0"
                                            step="0.01">
                                    </div>
                                </div>


                                <div id="products">
                                    <div class="row gx-3 mb-3" id="product_0">
                                        <div class="col-md-4">
                                            <label for="product_id_0" class="form-label required">Product</label>
                                            <select name="products[0][id]" class="form-select" required
                                                onchange="updateUnitCost(this)">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        data-selling-price="{{ $product->selling_price }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="quantity_0" class="form-label required">Quantity</label>
                                            <input type="number" name="products[0][quantity]" class="form-control"
                                                required min="1">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="unitcost_0" class="form-label">Unit Cost</label>
                                            <input type="number" name="products[0][unitcost]" class="form-control"
                                                required min="0" step="0.01" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end" style="direction:rtl">
                                <button type="submit" class="btn btn-primary">Create Purchase</button>
                                <button type="button" id="addProduct" class="btn btn-secondary">Add Another
                                    Product</button>
                            </div>
                            <div id="errorMessages" class="mt-3" style="display:none;">
                                <div class="alert alert-danger" role="alert"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function updateUnitCost(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const sellingPrice = selectedOption.getAttribute('data-selling-price');

                const productDiv = selectElement.closest('.row'); // Get the parent row of the select element
                const unitCostInput = productDiv.querySelector('input[name$="[unitcost]"]');

                if (sellingPrice) {
                    unitCostInput.value = sellingPrice; // Set the unit cost to the selling price
                } else {
                    unitCostInput.value = ''; // Clear the unit cost if no product is selected
                }
            }

            document.getElementById('addProduct').addEventListener('click', function () {
                const productsDiv = document.getElementById('products');
                const productCount = productsDiv.children.length; // Get the current count of product entries
                productsDiv.appendChild(createProductEntry(productCount));
            });

            function createProductEntry(count) {
                const newProductDiv = document.createElement('div');
                newProductDiv.classList.add('row', 'gx-3', 'mb-3');
                newProductDiv.id = `product_${count}`;

                newProductDiv.innerHTML = `
        <div class="col-md-4">
            <label for="product_id_${count}" class="form-label required">Product ${count + 1}</label>
            <select name="products[${count}][id]" class="form-select" required onchange="updateUnitCost(this)">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-selling-price="{{ $product->selling_price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="quantity_${count}" class="form-label required">Quantity</label>
            <input type="number" name="products[${count}][quantity]" class="form-control" required min="1">
        </div>
        <div class="col-md-4">
            <label for="unitcost_${count}" class="form-label">Unit Cost</label>
            <input type="number" name="products[${count}][unitcost]" class="form-control" required min="0" step="0.01" readonly>
        </div>
    `;

                return newProductDiv;
            }

            document.getElementById('purchaseForm').addEventListener('submit', function (event) {
                const errorMessages = document.getElementById('errorMessages');
                const alertDiv = errorMessages.querySelector('.alert');
                alertDiv.innerHTML = '';
                let hasErrors = false;

                document.querySelectorAll('.row[id^="product_"]').forEach((productDiv, index) => {
                    const quantity = productDiv.querySelector('input[name$="[quantity]"]').value;
                    const unitcost = productDiv.querySelector('input[name$="[unitcost]"]').value;

                    if (!quantity || quantity < 1) {
                        hasErrors = true;
                        alertDiv.innerHTML += `Product ${index + 1}: Please enter a valid quantity.<br>`;
                    }
                    if (!unitcost || unitcost < 0) {
                        hasErrors = true;
                        alertDiv.innerHTML += `Product ${index + 1}: Please enter a valid unit cost.<br>`;
                    }
                });

                if (hasErrors) {
                    event.preventDefault();
                    errorMessages.style.display = 'block';
                } else {
                    errorMessages.style.display = 'none';
                }
            });
        </script>
    </div>
</div>
@endsection