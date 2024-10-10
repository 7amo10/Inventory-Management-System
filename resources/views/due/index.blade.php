@extends('layouts.tabler')

@section('content')
<div class="page-body">
    @if(!$orders)
        <x-empty
            title="No orders found"
            message="Try adjusting your search or filter to find what you're looking for."
            button_label="{{ __('Add your first Order') }}"
            button_route="{{ route('orders.create') }}"
        />
    @else
        <div class="container-xl">

            {{---
            <div class="card">
                <div class="card-body">
                    <livewire:power-grid.orders-table/>
                </div>
            </div>
            ---}} 
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <h3 class="mb-1">Success</h3>
                    <p>{{ session('success') }}</p>

                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            @livewire('tables.order-table')
        </div>
    @endif
</div>
@endsection
