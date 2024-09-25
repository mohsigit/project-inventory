<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryRequest;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // List all inventories (available for both admin and users)
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventories.index', compact('inventories'));
    }

    // Show the form for creating a new inventory (admin only)
    public function create()
    {
        return view('inventories.create');
    }

    // Store a newly created inventory in storage (admin only)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        Inventory::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('inventories.index')->with('message', 'Inventory added successfully!');
    }

    // Show the specified inventory details (available for both admin and users)
    public function show(Inventory $inventory)
    {
        return view('inventories.show', compact('inventory'));
    }

    // Show the form for editing an inventory (admin only)
    public function edit(Inventory $inventory)
    {
        return view('inventories.edit', compact('inventory'));
    }

    // Update the specified inventory in storage (admin only)
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $inventory->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('inventories.index')->with('message', 'Inventory updated successfully!');
    }

    // Remove the specified inventory from storage (admin only)
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventories.index')->with('message', 'Inventory deleted successfully!');
    }

    // Allow users to request inventory (user only)
    public function requestInventory(Request $request)
    {
        // Validate the request
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        // Check if the inventory is available
        $inventory = Inventory::findOrFail($request->inventory_id);

        if ($inventory->quantity < 1) {
            return redirect()->back()->with('error', 'The requested inventory is out of stock.');
        }

        // Create the inventory request
        InventoryRequest::create([
            'user_id' => auth()->id(),
            'inventory_id' => $inventory->id,
        ]);

        // Decrement the inventory quantity
        $inventory->decrement('quantity');

        return redirect()->back()->with('message', 'Request submitted successfully!');
    }
}
