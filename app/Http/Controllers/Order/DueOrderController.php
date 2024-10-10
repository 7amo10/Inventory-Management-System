<?php

namespace App\Http\Controllers\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\StockAlert;
use App\Mail\PaymentReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DueOrderController extends Controller
{
    // 1. List all due orders
    public function index()
    {
        $orders = Order::where('due', '>', 0)
            ->latest()
            ->with('customer')
            ->get();

        return view('due.index', ['orders' => $orders]);
    }

    // 2. Show a specific due order
    public function show(Order $order)
    {
        $order->load('customer', 'orderDetails.product'); // Load necessary relationships

        return view('due.show', compact('order'));
    }

    // 3. Edit a due order
    public function edit(Order $order)
    {
        $order->load('customer', 'orderDetails.product');

        return view('due.edit', compact('order'));
    }

    // 4. Update a due order, handle partial payments, stock management, and notifications
    public function update(Order $order, Request $request)
    {
        // Validate incoming data
        $data = $request->validate([
            'payment_type' => 'required|string',
            'pay' => 'required|numeric|min:0',   // Payment amount must be valid
            'due' => 'nullable|numeric|min:0',   // Due amount cannot be negative
        ]);

        DB::beginTransaction();
        try {
            // Handle partial payments
            $newPay = $data['pay'];   // Amount being paid
            $remainingDue = $order->due - $newPay;  // Calculate the remaining due amount

            if ($remainingDue < 0) {
                return redirect()->back()->with('error', 'Payment exceeds the remaining due amount.');
            }

            // Update the order payment details
            $order->update([
                'payment_type' => $data['payment_type'],
                'pay' => $order->pay + $newPay,  // Accumulate the paid amount
                'due' => $remainingDue,          // Update the remaining due amount
            ]);

            // If payment clears the due amount, set the order as "Complete"
            if ($remainingDue == 0) {
                $order->update(['status' => 'Complete']);
            }

            // Restore stock if order details are modified
            foreach ($order->orderDetails as $orderDetail) {
                $product = $orderDetail->product;
                $product->increment('stock', $orderDetail->quantity);  // Restore stock based on quantity
                $orderDetail->delete();  // Optionally delete the order detail if no longer needed
            }

            // If stock falls below a threshold, send an alert email
            foreach ($order->orderDetails as $orderDetail) {
                $product = $orderDetail->product;
                // if ($product->stock < 10) {  // Assuming 10 as a low-stock threshold
                //     Mail::to(auth()->user()->email)->send(new StockAlert($product));
                // }
            }

            DB::commit();

            return redirect()->route('due.index')->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    // 5. Optionally, send payment reminder notifications to customers
    // public function sendPaymentReminder(Order $order)
    // {
    //     if ($order->due > 0) {
    //         Mail::to($order->customer->email)->send(new PaymentReminder($order));
    //         return redirect()->back()->with('success', 'Payment reminder sent successfully.');
    //     }

    //     return redirect()->back()->with('error', 'No due amount found for this order.');
    // }
}
