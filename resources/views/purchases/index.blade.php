@extends('layouts.tabler')
@section('title' , 'All Purchases')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @if($purchases->isEmpty())
            <div class="alert alert-warning">
                <h3 class="mb-1">No purchases available</h3>
                <p>It seems there are no purchases available at the moment. Try adding new purchases later.</p>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">Add Purchase</a>
            </div>
        @else
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">
                                {{ __('Purchases ') }}
                            </h3>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('purchases.create') }}" class="btn btn-icon btn-outline-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            </a>
                        </div>
                    </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->supplier->name }}</td> <!-- Assuming supplier model has 'name' -->
                            <td>{{ $purchase->date }}</td>
                            <td>${{ $purchase->total_amount }}</td>
                            <td>{{ $purchase->status }}</td>
                            <td>
                                <form action="{{ route('purchases.approve', $purchase->uuid) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <a href="{{ route('purchases.show', $purchase->uuid) }}"
                                    class="btn btn-secondary btn-sm">Show</a>

                                <a href="{{ route('purchases.edit', $purchase->uuid) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('purchases.delete', $purchase->uuid) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection