@extends('layouts.tabler')
@section('title' , 'Show Cateogry')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @livewire('tables.product-by-category-table', ['category' => $category])
    </div>
</div>
@endsection
