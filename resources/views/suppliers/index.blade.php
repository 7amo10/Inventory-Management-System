@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-warning">
                <h3 class="mb-1">No suppliers available</h3>
                <p>It seems there are no suppliers available at the moment. Try adding new suppliers later.</p>
                <a href="#" class="btn btn-primary">Add Supplier</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Supplier Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Example Supplier</td>
                    <td>example@example.com</td>
                    <td>+123456789</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Another Supplier</td>
                    <td>another@example.com</td>
                    <td>+987654321</td>
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
