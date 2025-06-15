<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Materialen overzicht voor admin
    public function materials(Request $request)
    {
        $query = Material::with('category');
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Status filter
        if ($request->has('status') && $request->status != '') {
            switch($request->status) {
                case 'available':
                    $query->where('is_available', true)->where('current_stock', '>', 0);
                    break;
                case 'low_stock':
                    $query->whereColumn('current_stock', '<=', 'minimum_stock')->where('current_stock', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('current_stock', 0);
                    break;
            }
        }
        
        $materials = $query->orderBy('name')->paginate(20)->withQueryString();
        
        return view('admin.materials', compact('materials'));
    }

    // Materiaal toevoegen form
    public function createMaterial()
    {
        $categories = Category::all();
        return view('admin.create-material', compact('categories'));
    }

    // Materiaal opslaan
    public function storeMaterial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'article_number' => 'nullable|string|unique:materials,article_number',
            'supplier' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
        ]);

        Material::create($request->all());

        return redirect()->route('admin.materials')->with('success', 'Materiaal toegevoegd!');
    }

    // Materiaal bewerken form
    public function editMaterial(Material $material)
    {
        $categories = Category::all();
        return view('admin.edit-material', compact('material', 'categories'));
    }

    // Materiaal updaten
    public function updateMaterial(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'article_number' => 'nullable|string|unique:materials,article_number,' . $material->id,
            'supplier' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
        ]);

        $material->update($request->all());

        return redirect()->route('admin.materials')->with('success', 'Materiaal bijgewerkt!');
    }

    // Materiaal verwijderen
    public function deleteMaterial(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials')->with('success', 'Materiaal verwijderd!');
    }
    
    // Quick stock update
    public function updateStock(Request $request, Material $material)
    {
        $request->validate([
            'current_stock' => 'required|integer|min:0'
        ]);
        
        $material->update(['current_stock' => $request->current_stock]);
        
        return redirect()->route('admin.materials')->with('success', 'Voorraad bijgewerkt!');
    }
    
    // Orders management
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.orders', compact('orders'));
    }
    
    // Order detail voor admin
    public function orderShow(Order $order)
    {
        $order->load(['orderItems.material.category', 'user']);
        return view('admin.order-show', compact('order'));
    }
    
    // Update order status
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,processing,delivered,cancelled'
        ]);
        
        $order->update(['status' => $request->status]);
        
        // Als order wordt goedgekeurd, verminder de voorraad
        if ($request->status == 'approved' && $order->status != 'approved') {
            foreach ($order->orderItems as $item) {
                $item->material->decreaseStock($item->quantity);
            }
        }
        
        return redirect()->back()->with('success', 'Order status bijgewerkt!');
    }
}