<?php

namespace App\Http\Controllers;

use App\Models\CakeFlavor;
use Illuminate\Http\Request;

class CakeFlavorController extends Controller
{
    public function index(Request $request)
    {
        $flavors = CakeFlavor::orderBy('name')->get();
        $editFlavor = null;

        if ($request->has('edit')) {
            $editFlavor = CakeFlavor::find($request->edit);
        }

        return view('admin.adminaccount', compact('flavors', 'editFlavor'));
    }
    // Add new flavor
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:cake_flavors,name',
        'additional_price' => 'required|numeric|min:0',
    ]);

    CakeFlavor::create([
        'name' => $request->name,
        'additional_price' => $request->additional_price,
        'status' => 'available',
    ]);

    return back()->with('success', 'New flavor added successfully.');
}


    public function toggleStatus($id)
    {
        $flavor = CakeFlavor::findOrFail($id);
        $flavor->status = $flavor->status === 'available' ? 'unavailable' : 'available';
        $flavor->save();

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'additional_price' => 'required|numeric'
        ]);

        $flavor = CakeFlavor::findOrFail($id);
        $flavor->update($request->only('name', 'additional_price'));

        return redirect()->route('admin.account')
            ->with('success', 'Flavor updated successfully.');
    }

    public function destroy($id)
    {
        CakeFlavor::findOrFail($id)->delete();

        return back()->with('success', 'Flavor deleted.');
    }
}
