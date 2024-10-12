@extends('layouts.tabler')
@section('title' , 'Quotations')

@section('content')
    <div class="page-body">
        <div class="empty">
            <p>No quotations found. Try adjusting your search or filter to find what you're looking for.</p>
            <a href="#" class="btn btn-primary">Add your first Quotation</a>
        </div>

        <div class="container-xl">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Quotation Title</th>
                        <th>Customer</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Quotation for Project A</td>
                        <td>John Doe</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Quotation for Project B</td>
                        <td>Jane Smith</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
