<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', auth()->id())->count();

        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
    }

    public function store(StoreCustomerRequest $request)
    {

    }

    public function show($uuid)
    {

    }

    public function edit($uuid)
    {

    }

    public function update(UpdateCustomerRequest $request, $uuid)
    {

    }

    public function destroy($uuid)
    {

    }
}
