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


class PurchaseController extends Controller
{
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
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();
        $suppliers = Supplier::all();  // Fetch all suppliers to change supplier

        return view('purchases.edit', compact('purchase', 'suppliers'));
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
        ]);

        // Generate purchase number automatically
        $purchaseNumber = $this->generatePurchaseNumber(); // Placeholder function

        // Initialize total amount
        $totalAmount = 0;

        // Calculate the total amount based on products
        foreach ($validated['products'] as $product) {
            $totalAmount += $product['quantity'] * $product['unitcost'];
        }

        // Create the purchase with total amount and user ID
        $purchase = Purchase::create([
            'supplier_id' => $validated['supplier_id'],
            'date' => $validated['date'],
            'total_amount' => $totalAmount, // Save the calculated total amount
            // 'taxes' => $validated['taxes'],
            'created_by' => auth()->id(), // Assuming you have an authenticated user
            'purchase_no' => $purchaseNumber, // Use your generated purchase number
            'uuid' => Str::uuid(), // Generate a UUID
            'user_id' => auth()->id(), // Set the user_id to the authenticated user
        ]);

        // Save the purchase details
        foreach ($validated['products'] as $product) {
            PurchaseDetails::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'unitcost' => $product['unitcost'],
                // 'taxes' => $product['taxes'],
                'total' => $product['quantity'] * $product['unitcost'], // Store total for each product

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

    /**
     * Update the specified purchase in the database.
     */
    public function update(StorePurchaseRequest $request, $uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();

        DB::beginTransaction();
        try {
            // Update purchase details
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'updated_by' => auth()->id(),
            ]);

            // Delete previous purchase details and add new ones
            $purchase->details()->delete();
            foreach ($request->products as $product) {
                PurchaseDetails::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'unitcost' => $product['unitcost'],
                    'total' => $product['quantity'] * $product['unitcost'],
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
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