@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if (!$products)
            <x-empty title="No products found" message="Try adjusting your search or filter to find what you're looking for."
                button_label="{{ __('Add your first Product') }}" button_route="{{ route('products.create') }}" />

            <div style="padding-top:-25px">
                <div style="text-align: center;">
                    <a href="{{ route('products.import.view') }}" class="">
                        {{ __('Import Products') }}
                    </a>
                </div>
            </div>
        @else
            <div class="container-xl">
                <x-alert />
                @livewire('tables.product-table')
            </div>
        @endif
    </div>
@endsection
