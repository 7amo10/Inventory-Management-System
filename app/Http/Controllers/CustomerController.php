<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\{Customer,User};
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', auth()->id())->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Define the custom path where you want to store the file
            $destinationPath = public_path('assets/img/customers/');

            // Ensure the directory exists or create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the directory if it doesn't exist
            }

            // Define the filename (optional: you can rename or use the original name)
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move the file to the specified folder
            $file->move($destinationPath, $fileName);

            // Save the path to the database (relative to the public folder)
            $data['photo'] = 'assets/img/customers/' . $fileName;
        }

        // $request->merge(["user_id" => auth()->user()->id]);

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer has been created successfully.');
    }

    public function show($uuid)
    {
        $customer = Customer::where('uuid' , $uuid)->firstOrFail();
        return view('customers.show' , compact('customer'));
    }

    public function edit($uuid)
    {
        $customer = Customer::where('uuid' , $uuid)->firstOrFail();
        return view('customers.edit' , compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, $uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();

        $data = $request->validated();

        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Define the custom path where you want to store the file
            $destinationPath = public_path('assets/img/customers/');

            // Ensure the directory exists or create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the directory if it doesn't exist
            }

            // Define the filename (optional: you can rename or use the original name)
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move the file to the specified folder
            $file->move($destinationPath, $fileName);

            // Save the path to the database (relative to the public folder)
            $data['photo'] = 'assets/img/customers/' . $fileName;
        }else {
            // Retain the existing photo if no new file is uploaded
            $data['photo'] = $customer->photo; // Keep the existing photo
        }

        // $request->merge(["user_id" => auth()->user()->id]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer has been updated successfully.');
    }

    public function destroy($uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer has been deleted successfully.');

    }
}
