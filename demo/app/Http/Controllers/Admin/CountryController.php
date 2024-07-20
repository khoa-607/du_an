<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Requests\CountryFormRequest;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $countries = Country::paginate(10);
        return view('admin.country.list', compact('countries'));
    }

    public function create()
    {
        return view('admin.country.add');
    }

    public function store(CountryFormRequest $request) 
    {
        Country::create($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.country.edit', compact('country'));
    }

    public function update(CountryFormRequest $request, $id) 
    {
        $country = Country::findOrFail($id);
        $country->update($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
