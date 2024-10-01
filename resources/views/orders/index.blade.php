@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-warning">
                <h3 class="mb-1">No orders available</h3>
                <p>It seems there are no orders available at the moment. Try adding new orders later.</p>
                <a href="#" class="btn btn-primary">Add Order</a>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice No.</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>INV-202309001</td>
                    <td>John Doe</td>
                    <td>2024-09-16</td>
                    <td>Credit Card</td>
                    <td>$1,200</td>
                    <td>
                        <span class="badge bg-green">Complete</span>
                    </td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">View</a>
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>INV-202309002</td>
                    <td>Jane Smith</td>
                    <td>2024-09-18</td>
                    <td>PayPal</td>
                    <td>$800</td>
                    <td>
                        <span class="badge bg-orange">Pending</span>
                    </td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">View</a>
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
                </tbody>
            </table>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <h3 class="mb-1">Success</h3>
                    <p>Order has been successfully added.</p>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <li>There was an error processing your order.</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
