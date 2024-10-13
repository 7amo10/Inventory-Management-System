@extends('layouts.tabler')
@section('title', 'Edit Purchase')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        {{ __('Purchase Edit') }}
                    </h3>
                </div>

                <div class="card-actions btn-actions">
                    <a href="{{ route('purchases.index') }}" class="btn-action">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l-12 12"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Start Form -->
            <form action="{{ route('purchases.update', $purchase->uuid) }}" method="POST">
                @csrf
                @method('PUT') <!-- Add this to use the PUT method for updating -->

                <div class="card-body">
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">

                        <label class="form-label required">Supplier Name</label>
                            <select class="form-control" name="supplier_id" id="supplier_id">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier->id == $purchase->supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Supplier Email</label>
                            <input type="email" class="form-control" id="supplier_email" name="supplier_email" disabled
                                value="{{ $purchase->supplier->email }}">
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Supplier Phone</label>
                            <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" disabled
                                value="{{ $purchase->supplier->phone }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier Address</label>
                            <input type="text" class="form-control" id="supplier_address" name="supplier_address"
                                value="{{ $purchase->supplier->address }}" disabled>
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Purchase No.</label>
                            <input type="text" class="form-control" name="purchase_no"  disabled
                                value="{{ $purchase->purchase_no }}">
                        </div>

                        <div class="col-md-6">

                            <label class="form-label required">Order Date</label>
                            <input type="date" class="form-control" name="order_date" value="{{ $purchase->date }}">
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Updated By</label>
                            <input type="text" class="form-control form-control-solid" disabled
                                value="{{ $purchase->updatedBy->name ?? '-' }}">
                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Purchase') }}
                    </button>
                </div>
            </form>
            <!-- End Form -->
        </div>
    </div>
</div>

<!-- Script to handle supplier details update -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#supplier_id').change(function () {
            var supplierID = $(this).val(); // Get the UUID from the dropdown
            if (supplierID) {
                $.ajax({
                    url: '../../suppliers/info/' + supplierID, // Use the new URL
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            // Populate the fields with the received data
                            $('#supplier_email').val(data.email);
                            $('#supplier_phone').val(data.phone);
                            $('#supplier_address').val(data.address);
                        } else {
                            // Clear fields if no data
                            $('#supplier_email').val('');
                            $('#supplier_phone').val('');
                            $('#supplier_address').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                        console.log(xhr.responseText); // Log the error response
                    }
                });
            } else {
                // Clear fields if no supplier is selected
                $('#supplier_email').val('');
                $('#supplier_phone').val('');
                $('#supplier_address').val('');
            }
        });
    });
</script>

@endsection
