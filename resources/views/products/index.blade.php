@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-warning">
                <h3 class="mb-1">No products available</h3>
                <p>It seems there are no products available at the moment. Try adding new products later.</p>
                <a href="#" class="btn btn-primary">Add Product</a>
                <div style="padding-top:10px; text-align: center;">
                    <a href="#">Import Products</a>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Product 1</td>
                    <td>Category A</td>
                    <td>$100</td>
                    <td>50</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Product 2</td>
                    <td>Category B</td>
                    <td>$200</td>
                    <td>30</td>
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
