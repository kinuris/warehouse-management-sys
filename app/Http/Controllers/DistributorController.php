<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('distributor.distributor-management');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'authority_name' => 'required|string|max:255',
            'email' => 'required|email|unique:distributors,email',
            'contact_number' => 'required|string|max:15',
        ]);

        $distributor = new Distributor();

        $distributor->name = $request->input('name');
        $distributor->authority_name = $request->input('authority_name');
        $distributor->email = $request->input('email');
        $distributor->contact_number = $request->input('contact_number');

        $distributor->save();

        return redirect()->route('distributor')->with('success', 'Distributor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        return view('distributor.distributor-edit', compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:distributors,email,' . $distributor->id,
            'contact_number' => 'required|string|max:15',
        ]);

        $distributor->name = $request->input('name');
        $distributor->email = $request->input('email');
        $distributor->contact_number = $request->input('contact_number');
        $distributor->save();

        return redirect()->route('distributor')->with('success', 'Distributor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()->route('distributor')->with('success', 'Distributor deleted successfully.');
    }
}
