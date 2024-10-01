<?php

namespace App\Http\Controllers\Quotation;

use App\Enums\QuotationStatus;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\Quotation\StoreQuotationRequest;
use Illuminate\Support\Facades\Request;
use Str;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::where("user_id",auth()->id())->count();

        return view('quotations.index', [
            'quotations' => $quotations
        ]);
    }

    public function create()
    {

    }

    public function store(StoreQuotationRequest $request)
    {

    }

    public function show($uuid)
    {

    }

    public function destroy(Quotation $quotation)
    {

    }

    // complete quotaion method
    public function update(Request $request,$uuid)
    {

    }
}
