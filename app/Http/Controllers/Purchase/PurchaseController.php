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
    public function index()
    {
        return view('purchases.index', [
            'purchases' => Purchase::where('user_id',auth()->id())->count()
        ]);
    }

    public function approvedPurchases()
    {

    }

    public function show($uuid)
    {

    }

    public function edit($uuid)
    {

    }

    public function create()
    {

    }

    public function store(StorePurchaseRequest $request)
    {

    }

    public function update($uuid)
    {

    }

    public function destroy($uuid)
    {

    }


    public function purchaseReport()
    {

    }

    public function getPurchaseReport()
    {
    }

    public function exportPurchaseReport(Request $request)
    {

    }

    public function exportExcel($products)
    {

    }
}
