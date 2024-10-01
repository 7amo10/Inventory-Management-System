@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-warning">
                <h3 class="mb-1">No purchases available</h3>
                <p>It seems there are no purchases available at the moment. Try adding new purchases later.</p>
                <a href="#" class="btn btn-primary">Add Purchase</a>
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
                <tr>
                    <td>1</td>
                    <td>Supplier A</td>
                    <td>2024-09-15</td>
                    <td>$500</td>
                    <td>Completed</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Supplier B</td>
                    <td>2024-09-18</td>
                    <td>$300</td>
                    <td>Pending</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
