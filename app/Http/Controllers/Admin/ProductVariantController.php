<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = ProductVariant::with(['product', 'branch'])->latest()->paginate(10);
        return view('admin.product_variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $branches = Branch::all();
        return view('admin.product_variants.create', compact('products', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['company_id'] = 1; // Temporary fix

        ProductVariant::create($data);

        return redirect()->route('admin.product-variant.index')->with('success', 'Variant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $products = Product::all();
        $branches = Branch::all();
        return view('admin.product_variants.edit', compact('productVariant', 'products', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $productVariant->update($request->all());

        return redirect()->route('admin.product-variant.index')->with('success', 'Variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return redirect()->route('admin.product-variant.index')->with('success', 'Variant deleted successfully.');
    }
}
