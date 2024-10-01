@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="empty">
            <div class="empty-icon">
                <!-- Add an SVG icon here -->
            </div>
            <p class="empty-title">No orders found</p>
            <p class="empty-subtitle text-secondary">Try adjusting your search or filter to find what you're looking for.</p>
            <div class="empty-action">
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    Add your first Order
                </a>
            </div>
        </div>

        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <x-status dot color="green" class="text-uppercase">
                        Complete
                    </x-status>
                    <div class="card-actions">
                        <a href="{{ route('purchases.create') }}" class="btn btn-icon btn-outline-success">Add Purchase</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center">{{ __('No.') }}</th>
                            <th scope="col" class="text-center">{{ __('Invoice No.') }}</th>
                            <th scope="col" class="text-center">{{ __('Customer') }}</th>
                            <th scope="col" class="text-center">{{ __('Date') }}</th>
                            <th scope="col" class="text-center">{{ __('Payment') }}</th>
                            <th scope="col" class="text-center">{{ __('Total') }}</th>
                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">INV-1001</td>
                            <td class="text-center">John Doe</td>
                            <td class="text-center">01-01-2024</td>
                            <td class="text-center">Credit Card</td>
                            <td class="text-center">€100.00</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-icon btn-outline-success">View</a>
                                <a href="#" class="btn btn-icon btn-outline-warning">Download</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">INV-1002</td>
                            <td class="text-center">Jane Smith</td>
                            <td class="text-center">02-01-2024</td>
                            <td class="text-center">PayPal</td>
                            <td class="text-center">€200.00</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-icon btn-outline-success">View</a>
                                <a href="#" class="btn btn-icon btn-outline-warning">Download</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <!-- You can add footer content here -->
                </div>
            </div>
        </div>
    </div>
@endsection
