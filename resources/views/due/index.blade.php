@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="empty">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-happy" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 9l.01 0" /><path d="M15 9l.01 0" /><path d="M8 13a4 4 0 1 0 8 0h-8" /></svg>
            </div>
            <p class="empty-title">No due orders found</p>
        </div>

        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Due Order List</h3>
                    </div>
                    <div class="card-actions">
                        <a href="#" class="btn btn-primary">Add Order</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered card-table table-vcenter text-nowrap">
                        <thead class="thead-light">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Invoice No.</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Payment</th>
                            <th class="text-center">Pay</th>
                            <th class="text-center">Due</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">INV-202309001</td>
                            <td class="text-center">John Doe</td>
                            <td class="text-center">2024-09-16</td>
                            <td class="text-center">Credit Card</td>
                            <td class="text-center"><span class="badge bg-green text-white">€500</span></td>
                            <td class="text-center"><span class="badge bg-yellow text-white">€100</span></td>
                            <td class="text-center"><a href="#" class="btn btn-sm btn-warning">Edit</a></td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">INV-202309002</td>
                            <td class="text-center">Jane Smith</td>
                            <td class="text-center">2024-09-18</td>
                            <td class="text-center">PayPal</td>
                            <td class="text-center"><span class="badge bg-green text-white">€800</span></td>
                            <td class="text-center"><span class="badge bg-yellow text-white">€200</span></td>
                            <td class="text-center"><a href="#" class="btn btn-sm btn-warning">Edit</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
