@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="empty">
            <p>No units found. Try adjusting your search or filter to find what you're looking for.</p>
            <a href="#" class="btn btn-primary">Add your first Unit</a>
        </div>

        <div class="container-xl">
            <div class="alert alert-success alert-dismissible" role="alert">
                <h3 class="mb-1">Success</h3>
                <p>Unit added successfully.</p>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Unit Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Kilogram</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Liter</td>
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
