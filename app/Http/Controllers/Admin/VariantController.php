<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = Variant::latest()->paginate(10);
        return view('admin.variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.variants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Variant::create($request->all());

        return redirect()->route('admin.variant.index')->with('success', 'Variant created successfully.');
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
    public function edit(Variant $variant)
    {
        return view('admin.variants.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $variant->update($request->all());

        return redirect()->route('admin.variant.index')->with('success', 'Variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        $variant->delete();
        return redirect()->route('admin.variant.index')->with('success', 'Variant deleted successfully.');
    }
}
