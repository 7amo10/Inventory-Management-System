<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where("user_id", auth()->id())->count();

        return view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
    }

    public function store(StoreSupplierRequest $request)
    {

    }

    public function show($uuid)
    {

    }

    public function edit($uuid)
    {

    }

    public function update(UpdateSupplierRequest $request, $uuid)
    {

    }

    public function destroy($uuid)
    {

    }
}
