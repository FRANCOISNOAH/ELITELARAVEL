<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.country.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Country::create($request->validate([
            'name_en' => 'string|unique:countries,name_en',
            'name_fr' => 'string|unique:countries,name_fr',
        ]));


        if ($request->ajax()) {
            $redirectRoute = route('countries.index');
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('countries.index')->with('success', 'Pays crée avec succès.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $country =  Country::with('cities')->find($id);
        return view('admin.country.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('admin.country.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $country->update($request->validate([
            'name_en' => 'string',
            'name_fr' => 'string',
        ]));
        if ($request->ajax()) {
            $redirectRoute = route('countries.index');
            return response()->json(['status' => 'success', 'redirect' => $redirectRoute]);
        } else {
            return redirect()->route('countries.index')->with('success', 'Pays crée avec succès.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $cities = $country->cities;
        foreach ($cities as $city) {
            $city->delete();
        }
        $country->delete();

        return back()->with('success', 'Pays et villes associées supprimées avec succès.');
    }
}
