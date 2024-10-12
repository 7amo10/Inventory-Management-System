@extends('layouts.tabler')
@section('title' , 'Suppliers')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            @if ($suppliers->isEmpty())
            <div class="alert alert-warning">
                <h3 class="mb-1">No suppliers available</h3>
                <p>It seems there are no suppliers available at the moment. Try adding new suppliers later.</p>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
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
                @livewire('tables.supplier-table')
            </div>
        @endif
        </div>
    </div>
@endsection
