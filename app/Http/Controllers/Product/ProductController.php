<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
        ->get();

        return view('products.index', compact('products'));
    }

    public function create(Request $request)
    {

    $categories = Category::all();
    $units = Unit::all();
    $suppliers = Supplier::all();

        return view('products.create', compact('categories', 'units' , 'suppliers'));
    }

    public function store(StoreProductRequest $request)
{
    $data = $request->validated();

    $data['uuid'] = Str::uuid();
    $data['user_id'] = auth()->id();
    $data['slug'] = Str::slug($data['name']);
//    $data['image'] = Str::uuid();
//    if ($request->hasFile('product_image')) {
//        $file = $request->file('product_image');
//
//        // Define the custom path where you want to store the file
//        $destinationPath = public_path('assets/img/products/');
//
//        // Ensure the directory exists or create it
//        if (!file_exists($destinationPath)) {
//            mkdir($destinationPath, 0755, true); // Create the directory if it doesn't exist
//        }
//
//        // Define the filename (optional: you can rename or use the original name)
//        $fileName = time() . '_' . $file->getClientOriginalName();
//
//        // Move the file to the specified folder
//        $file->move($destinationPath, $fileName);
//
//        // Save the path to the database (relative to the public folder)
//        $data['product_image'] = 'assets/img/products/' . $fileName;
//    }
        $image = "";
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image')->store('products', 'public');
        }

        Product::create($data);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}

    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $barcode = (new BarcodeGeneratorHTML())->getBarcode($product->code, 'C128'); // Generate barcode

        return view('products.show', compact('product', 'barcode'));
    }

    public function edit($uuid)
{
    $product = Product::where('uuid', $uuid)->firstOrFail();

    $categories = Category::all();
    $units = Unit::all();
    $suppliers = Supplier::all();

    return view('products.edit', compact('product', 'categories' , 'units' , 'suppliers'));
}

    public function update(UpdateProductRequest $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $data = $request->validated();

        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['name']);


        if ($request->hasFile('product_image')) {
            // Get the uploaded file
            $file = $request->file('product_image');

            // Define the filename with a timestamp
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Define the path where the image will be stored
            $destinationPath = public_path('assets/img/products');

            // Ensure the directory exists or create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the directory if it doesn't exist
            }

            // Move the file to the specified folder
            $file->move($destinationPath, $fileName);

            // Store the relative path in the database
            $data['product_image'] = 'assets/img/products/' . $fileName;
        } else {
            // Retain the existing photo if no new file is uploaded
            $data['product_image'] = $product->product_image; // Keep the existing photo
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();

        if ($product->user_id !== auth()->id()) {
            return redirect()->route('products.index')->with('error', 'Unauthorized action.');
        }

        if ($product->product_image) {
            // check if image exists in our file system
            if (file_exists(public_path('storage/') . $product->product_image)) {
                unlink(public_path('storage/') . $product->product_image);
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
