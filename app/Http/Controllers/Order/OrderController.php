<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use App\Mail\StockAlert;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $carts = Cart::content();
        $products = Product::all();
        return view('orders.create' , compact('customers' , 'carts' , 'products'));
    }

    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();
    
        DB::beginTransaction();
    
        try {    
            // Create the order
            $order = Order::create([
                'uuid'           => $data['uuid'],
                'user_id'        => $data['user_id'],
                'customer_id'    => $data['customer_id'],
                'payment_type'   => $data['payment_type'],
                'subtotal'       => $data['subtotal'],
                'vat'            => $data['vat'],
                'total'          => $data['total'],
                'pay'            => $data['pay'],
                'order_date'     => $data['order_date'],
                'due'            => $data['total'] - $data['pay'],
            ]);
    
            // Fetch all product IDs from the request once, outside the loop
            $productIds = collect($data['products'])->pluck('id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
    
            $lowStockProducts = [];
            foreach ($data['products'] as $product) {
                $productModel = $products[$product['id']]; // Fetch product from the collection
    
                // Check stock availability
                if ($productModel->stock < $product['quantity']) {
                    $lowStockProducts[] = $productModel->name;
                    throw new \Exception("Insufficient stock for {$productModel->name}");
                }
    
                // Create order details and adjust stock
                OrderDetails::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product['id'],
                    'quantity'      => $product['quantity'],
                    'price'         => $product['price'],
                    'total'         => $product['price'] * $product['quantity'],
                ]);
    
                // Decrement stock
                $productModel->decrement('stock', $product['quantity']);
            }
    
            DB::commit();
    
            // Send stock alert emails after committing the transaction
            if (!empty($lowStockProducts)) {
                Mail::to(auth()->user()->email)->send(new StockAlert($lowStockProducts));
            }
    
            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'Order creation failed. Please try again.']);
        }
    }
    

    public function show($uuid)
    {
        $order = Order::where('uuid' , $uuid)->firstOrFail();
        return view('orders.show', compact('order'));
    }

    public function update($uuid, Request $request)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail(); // Retrieve the order by UUID

        // Validate the incoming request (you can move this logic to a FormRequest for better separation)
        $data = $request->validate([
            'payment_type'   => 'string|required',
            'pay'            => 'numeric|required',
            'customer_id'    => 'required|exists:customers,id',
            'products'       => 'required|array',
            'products.*.id'  => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'subtotal'       => 'required|numeric',
            'vat'            => 'required|numeric',
            'total'          => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Update the order details
            $order->update([
                'customer_id'    => $data['customer_id'],
                'payment_type'   => $data['payment_type'],
                'subtotal'       => $data['subtotal'],
                'vat'            => $data['vat'],
                'total'          => $data['total'],
                'pay'            => $data['pay'],
                'order_date'     => now(),
            ]);

            // Update the order details (products)
            // Step 1: Restore the stock for the existing products in the order
            foreach ($order->orderDetails as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                $product->increment('stock', $orderDetail->quantity); // Restore the stock
            }

            // Step 2: Remove the existing order details
            $order->orderDetails()->delete();

            // Step 3: Insert new order details and adjust stock
            foreach ($data['products'] as $productData) {
                $product = Product::find($productData['id']);
                
                if ($product->stock < $productData['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Create new order details
                OrderDetails::create([
                    'order_id'   => $order->id,
                    'product_id' => $productData['id'],
                    'quantity'   => $productData['quantity'],
                    'price'      => $productData['price'],
                    'total'      => $productData['price'] * $productData['quantity'],
                ]);

                // Update the stock
                $product->decrement('stock', $productData['quantity']);
            }

            DB::commit();

            return redirect()->route('orders.show', $order->uuid)->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update order. Please try again.');
        }
    }

    public function destroy($uuid)
    {
        $order = Order::where('uuid' , $uuid)->firstOrFail();
        $order->delete();
        return redirect()
        ->route('orders.index')
        ->with('success' ,'The order has been deleted successfully');

    }

    public function downloadInvoice($uuid)
    {
        $order = Order::where('uuid' , $uuid)->firstOrFail();
        return view('orders.print-invoice' , compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->status === OrderStatus::COMPLETE) {
            return redirect()->back()->with('error', 'Completed orders cannot be canceled.');
        }
    
        // 2. Update the order status to "Canceled"
        $order->status = OrderStatus::CANCEL;
        $order->canceled_at = now(); // Record the time of cancellation
        $order->save();
    
        // 3. Restore the stock if applicable (if you reduce stock when an order is placed)
        foreach ($order->products as $orderDetail) {
            $product = $orderDetail->product;
            $product->stock += $orderDetail->quantity;
            $product->save();
        }
    
        // 4. Optionally, notify the customer about the cancellation
        Mail::to($order->customer->email)->send(new OrderCanceledNotification($order));
    
        // 5. Redirect with a success message
        return redirect()->route('orders.index')->with('success', 'Order has been canceled successfully.');
    }
}
