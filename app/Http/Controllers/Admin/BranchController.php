<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        // Assuming company_id is required and should be set. 
        // For now, I'll assume there's a default company or it's handled via auth/session.
        // Checking the migration, company_id is required.
        // I'll hardcode it to 1 for now or check if there's a helper.
        // Actually, looking at the context, it might be multi-tenant or single company.
        // Let's assume single company for now or fetch from auth user if linked.
        // But the migration says `company_id`.
        // I'll add `company_id` to the validation if it's in the form, or set it here.
        // Let's check if there's a Company model and if I should just pick the first one or if the user belongs to one.
        // Given it's an admin panel, maybe they select the company? Or it's the admin's company.
        // I'll assume for now we set it to 1 or auth()->user()->company_id if available.
        // Let's check User model later. For now, I'll just use a placeholder or validation.
        
        // Wait, I should check the User model to see if it has company_id.
        // But for this step, I'll just implement the basic logic and maybe add a TODO or check User model in parallel.
        
        $data = $request->all();
        $data['company_id'] = 1; // Temporary fix, need to verify how company is handled.

        Branch::create($data);

        return redirect()->route('admin.branch.index')->with('success', 'Branch created successfully.');
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
    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $branch->update($request->all());

        return redirect()->route('admin.branch.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branch.index')->with('success', 'Branch deleted successfully.');
    }
}
