<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\BrandFormRequest;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('admin.brand.list', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.add');
    }

    public function store(BrandFormRequest $request) 
    {
        Brand::create($request->validated());
        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit($id)
    {
        $brands = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function update(BrandFormRequest $request, $id) 
    {
        $brands = Brand::findOrFail($id);
        $brands->update($request->validated());
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brands = Brand::findOrFail($id);
        $brands->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
