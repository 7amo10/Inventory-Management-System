@extends('layouts.tabler')
@section('title' , 'Show Unit')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @livewire('tables.product-by-unit-table', ['unit' => $unit])
    </div>
</div>
@endsection
