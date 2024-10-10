<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\Invoice\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    // 1. Method to show the invoice creation form (GET request)
    public function showCreateForm()
    {
        // Fetch customer and cart data for the view
        $customer = Customer::first(); // Adjust this as needed to fetch the correct customer
        $carts = Cart::content();      // Fetch the cart items

        // Render the form view with customer and cart data
        // return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    // 2. Method to handle invoice creation (POST request)
    public function create(StoreInvoiceRequest $request , Customer $customer)
    {
        // Validate request
        $customer = Customer::where('id', $request->get('customer_id'))
        ->first();

        $user = auth()->user();

        $carts = Cart::content();

        return view('invoices.create', compact('customer' , 'user' , 'carts'));
    }
}


?>