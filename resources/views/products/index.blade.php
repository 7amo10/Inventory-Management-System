@extends('layouts.tabler')
@section('title' , 'Products')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            @if ($products->isEmpty())
            <div class="alert alert-warning">
                <h3 class="mb-1">No products available</h3>
                <p>It seems there are no products available at the moment. Try adding new products later.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                <div style="padding-top:10px; text-align: center;">
                    <a href="{{ route('products.import.view') }}" class="btn btn-primary">Import Products</a>
                </div>
            </div>
            @else

            <div class="container-xl">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <h3 class="mb-1">Success</h3>
                        <p>{{ session('success') }}</p>

                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                @livewire('tables.product-table')
            </div>
        @endif
        </div>
    </div>
@endsection
