@extends('layouts.tabler')
@section('title' , 'Users')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @livewire('tables.user-table')
    </div>
</div>
@endsection
