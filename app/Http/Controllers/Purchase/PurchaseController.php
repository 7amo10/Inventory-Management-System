<?php

namespace App\Http\Controllers\Purchase;

use App\Enums\PurchaseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Str;
use Illuminate\Support\Facades\Log;



class PurchaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Ensures that the user is authenticated
    }

    /**
     * Display a listing of the purchases.
     */
    public function index()
    {
        // Fetch purchases of the logged-in user with related supplier details
        $purchases = Purchase::with('supplier')->where('user_id', auth()->id())->get();

        return view('purchases.index', compact('purchases'));
    }


    /**
     * Display a listing of approved purchases.
     */
    public function approvedPurchases()
    {
        $purchases = Purchase::with('supplier') // Eager load the supplier
            ->where('user_id', auth()->id())
            ->where('status', 1) // Assuming status 1 means approved
            ->get();

        return view('purchases.approved', compact('purchases'));
    }



    /**
     * Show the specified purchase.
     */
    public function show($uuid)
    {
        // Eager load supplier and details for the specific purchase
        $purchase = Purchase::with(['supplier', 'details.product']) // Make sure to include 'supplier'
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('purchases.show', compact('purchase'));
    }



    /**
     * Show the form for editing the specified purchase.
     */
    public function edit($uuid)
    {
        $purchase = Purchase::with('supplier')->where('uuid', $uuid)->first();
        $suppliers = Supplier::all();
        $products = $purchase->details; // Fetch associated purchase details (products)
    
        return view('purchases.edit', compact('purchase', 'suppliers', 'products'));
    }
    
    

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase in the database.
     */

     public function store(Request $request)
     {
         // Validate the request data
         $validated = $request->validate([
             'date' => 'required|date',
             'supplier_id' => 'required|exists:suppliers,id',
             'reference' => 'required|string',
             'products' => 'required|array',
             'products.*.id' => 'required|exists:products,id',
             'products.*.quantity' => 'required|integer|min:1',
             'products.*.unitcost' => 'required|numeric|min:0',
             'tax_rate' => 'required|numeric|min:0', // Validate a single tax rate for the entire purchase
         ]);
     
         // Generate purchase number automatically
         $purchaseNumber = $this->generatePurchaseNumber(); // Placeholder function
     
         // Initialize total amount
         $totalAmount = 0;
     
         // Calculate the total amount based on products
         foreach ($validated['products'] as $product) {
             $totalAmount += $product['quantity'] * $product['unitcost']; // Accumulate total amount
         }
     
         // Calculate the total tax amount based on the total price
         $taxAmount = $totalAmount * ($validated['tax_rate'] / 100);
     
         // Calculate the total amount including taxes
         $totalAmountWithTaxes = $totalAmount + $taxAmount;
     
         // Create the purchase with total amount and user ID
         $purchase = Purchase::create([
             'supplier_id' => $validated['supplier_id'],
             'date' => $validated['date'],
             'total_amount' => $totalAmountWithTaxes, // Save the total amount with taxes
             'taxes' => $taxAmount, // Save the total taxes amount for the purchase
             'created_by' => auth()->id(), // Assuming you have an authenticated user
             'purchase_no' => $purchaseNumber, // Use your generated purchase number
             'uuid' => Str::uuid(), // Generate a UUID
             'user_id' => auth()->id(), // Set the user_id to the authenticated user
         ]);
     
         // Save the purchase details without storing tax information for each product
         foreach ($validated['products'] as $product) {
             $productTotal = $product['quantity'] * $product['unitcost']; // Calculate total for each product
     
             PurchaseDetails::create([
                 'purchase_id' => $purchase->id,
                 'product_id' => $product['id'],
                 'quantity' => $product['quantity'],
                 'unitcost' => $product['unitcost'],
                 'total' => $productTotal, // Store total for each product
                 // No need to store tax amount for each product
             ]);
         }
     
         // Optionally return a response or redirect
         return redirect()->route('purchases.index')->with('success', 'Purchase created successfully!');
     }
     

    // Placeholder function for generating purchase numbers
    private function generatePurchaseNumber()
    {
        // Implement your logic for generating a purchase number
        return 'PUR-' . time(); // Example: Generates a unique purchase number
    }

   public function update(StorePurchaseRequest $request, $uuid)
{
    $purchase = Purchase::where('uuid', $uuid)->first();

    // Start a database transaction
    DB::beginTransaction();
    try {
        // Initialize total amount
        $totalAmount = 0;

        // Only proceed if products exist in the request
        if ($request->has('products') && is_array($request->products)) {
            // Delete previous purchase details
            $purchase->details()->delete();

            // Loop through new products to add and calculate total
            foreach ($request->products as $product) {
                // Ensure required fields are present
                if (isset($product['id'], $product['quantity'], $product['unitcost'])) {
                    $productTotal = $product['quantity'] * $product['unitcost'];
                    $totalAmount += $productTotal; // Update total amount

                    // Add the new product details
                    PurchaseDetails::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                        'unitcost' => $product['unitcost'],
                        'total' => $productTotal,
                    ]);
                }
            }
        }

        // Update purchase details, including recalculated total amount
        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'date' => $request->order_date,
            'total_amount' => $totalAmount > 0 ? $totalAmount : $purchase->total_amount, // Only update if totalAmount > 0
            'updated_by' => auth()->id(), // This should correctly save the user ID
        ]);

        // Commit the transaction
        DB::commit();

        // Redirect back to purchases index with a success message
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    } catch (Exception $e) {
        // Roll back the transaction in case of an error
        DB::rollBack();
        
        // Redirect back with an error message
        return back()->withErrors(['error' => 'Error updating purchase: ' . $e->getMessage()]);
    }
}

    
    

    public function approve($uuid)
    {
        // Find the purchase by UUID
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();

        // Update the status to approved (assuming 1 represents 'approved')
        $purchase->status = 1;
        $purchase->save();

        // Redirect back with a success message
        return redirect()->route('purchases.index')->with('success', 'Purchase approved successfully.');
    }


    /**
     * Remove the specified purchase from the database.
     */
    public function destroy($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }

    /**
     * Display the purchase report view.
     */
    public function purchaseReport()
    {
        return view('purchases.report');
    }

    /**
     * Generate the purchase report based on user input (date filters, etc.).
     */

    public function getPurchaseReport(Request $request)
    {
        $purchases = Purchase::where('user_id', auth()->id())
            ->when($request->from_date, function ($query) use ($request) {
                return $query->whereDate('date', '>=', Carbon::parse($request->from_date));
            })
            ->when($request->to_date, function ($query) use ($request) {
                return $query->whereDate('date', '<=', Carbon::parse($request->to_date));
            })
            ->with(['supplier', 'products']) // Eager load suppliers and products
            ->get();

        return view('purchases.report', compact('purchases'));
    }
    /**
     * Export the purchase report to Excel using joins.
     */
    public function exportPurchaseReport(Request $request)
    {
        // Fetch purchases with joined product details
        $purchases = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->join('products', 'purchase_details.product_id', '=', 'products.id')
            ->select(
                'purchases.purchase_no',
                'suppliers.name as supplier_name',
                'purchases.date',
                'purchases.total_amount',
                'purchases.status',
                'products.name as product_name',
                'products.code as product_code',
                'purchase_details.quantity',
                'purchase_details.unitcost as unit_cost', // Use unitcost from purchase_details
                DB::raw("CASE WHEN purchases.created_by = 1 THEN 'Admin' ELSE 'User' END as created_by") // Conditional logic
            )
            ->where('purchases.user_id', auth()->id())
            ->get();

        return $this->exportExcel($purchases);
    }
    public function exportExcel($purchases)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the column headings
        $sheet->setCellValue('A1', 'Purchase No');
        $sheet->setCellValue('B1', 'Supplier');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Total Amount');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Product');
        $sheet->setCellValue('G1', 'Product Code');
        $sheet->setCellValue('H1', 'Quantity');
        $sheet->setCellValue('I1', 'Unit Cost');
        $sheet->setCellValue('J1', 'Created By');

        // Fill data
        $row = 2;
        foreach ($purchases as $purchase) {
            $sheet->setCellValue("A{$row}", $purchase->purchase_no);
            $sheet->setCellValue("B{$row}", $purchase->supplier_name);
            $sheet->setCellValue("C{$row}", $purchase->date);
            $sheet->setCellValue("D{$row}", $purchase->total_amount);
            $sheet->setCellValue("E{$row}", $purchase->status ? 'Completed' : 'Pending');
            $sheet->setCellValue("F{$row}", $purchase->product_name);
            $sheet->setCellValue("G{$row}", $purchase->product_code);
            $sheet->setCellValue("H{$row}", $purchase->quantity);
            $sheet->setCellValue("I{$row}", $purchase->unit_cost);
            $sheet->setCellValue("J{$row}", $purchase->created_by);
            $row++;
        }

        // Save as Excel
        $writer = new Xls($spreadsheet);
        $filename = "purchases_report_" . now()->format('Y-m-d') . ".xls";

        // Return the file as a download
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }
}