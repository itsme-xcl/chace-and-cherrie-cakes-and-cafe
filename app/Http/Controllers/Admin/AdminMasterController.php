<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMasterController extends Controller
{
    public function store(Request $request, $type)
    {
        $model = $this->model($type);

        $model::create([
            'name' => $request->name,
            'additional_price' => $request->additional_price,
            'status' => 'available', // ✅ ensure default status
        ]);

        return back()->with('success', 'Added successfully.');
    }

    public function update(Request $request, $type, $id)
    {
        $model = $this->model($type);
        $item  = $model::findOrFail($id);

        $item->update($request->only('name', 'additional_price'));

        return back()->with('success', 'Updated successfully.');
    }

    public function toggle($type, $id)
    {
        $model = $this->model($type);
        $item  = $model::findOrFail($id);

        $item->status = $item->status === 'available'
            ? 'unavailable'
            : 'available';

        $item->save();

        return back();
    }

    public function destroy($type, $id)
    {
        $model = $this->model($type);
        $model::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully.');
    }

    private function model($type)
    {
        return match ($type) {
            'flavors'   => \App\Models\CakeFlavor::class,
            'sizes'     => \App\Models\CakeSize::class,
            'addons'    => \App\Models\CakeAddon::class,
            'themes'    => \App\Models\CakeTheme::class,
            'frostings' => \App\Models\FrostingType::class,   // ✅ ADDED
            'fondants'  => \App\Models\FondantOption::class,  // ✅ ADDED
            default     => abort(404),
        };
    }
}