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
            switch ($request->status) {
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

    // Toon individueel materiaal
    public function showMaterial(Material $material)
    {
        $material->load(['category', 'orderItems.order.user']);
        
        return view('admin.materials.show', compact('material'));
    }

    // Materiaal toevoegen form
    public function createMaterial()
    {
        $categories = Category::all();
        return view('admin.materials.create', compact('categories'));
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

    // Materiaal bewerken form EN verwerken van updates
    public function editMaterial(Request $request, Material $material)
    {
        // Als het een POST request is (form submission)
        if ($request->isMethod('post')) {
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
                'is_available' => 'boolean',
            ]);

            // Update het materiaal
            $material->update($request->all());

            return redirect()->route('admin.materials')->with('success', 'Materiaal bijgewerkt!');
        }
        
        // Als het een GET request is (toon form)
        $categories = Category::all();
        return view('admin.materials.edit', compact('material', 'categories'));
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
    public function showOrder(Order $order)
    {
        $order->load(['orderItems.material.category', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,processing,delivered,cancelled'
        ]);
        
        $oldStatus = $order->status;
        
        // SPECIALE BEHANDELING voor order goedkeuring
        if ($request->status == 'approved' && $oldStatus != 'approved') {
            
            // Check voorraad voor alle items
            $stockIssues = [];
            
            foreach ($order->orderItems as $item) {
                // Fresh data ophalen
                $material = Material::find($item->material_id);
                
                if (!$material || !$material->is_available) {
                    $stockIssues[] = "{$item->material->name}: niet meer beschikbaar";
                    continue;
                }
                    
                if ($material->current_stock < $item->quantity) {
                    $stockIssues[] = "{$material->name}: gevraagd {$item->quantity} {$item->unit}, beschikbaar {$material->current_stock} {$material->unit}";
                }
            }
            
            if (!empty($stockIssues)) {
                return redirect()->back()->with('error', 
                    '❌ Kan order niet goedkeuren - voorraad problemen:<br>• ' . implode('<br>• ', $stockIssues) .
                    '<br><br>💡 <strong>Oplossing:</strong> Pas eerst de voorraad aan via materiaal beheer.'
                );
            }
            
            // Update order status
            $order->update(['status' => $request->status]);
            
            // Verminder voorraad
            foreach ($order->orderItems as $item) {
                $item->material->decreaseStock($item->quantity);
            }
            
            return redirect()->back()->with('success', 
                "✅ Order {$order->order_number} goedgekeurd! Voorraad is automatisch aangepast."
            );
        }
        
        // Voor andere status updates
        $order->update(['status' => $request->status]);
        
        $statusLabels = [
            'pending' => 'In afwachting',
            'approved' => 'Goedgekeurd', 
            'processing' => 'In verwerking',
            'delivered' => 'Geleverd',
            'cancelled' => 'Geannuleerd'
        ];
        
        return redirect()->back()->with('success', 
            "Order status gewijzigd naar: " . ($statusLabels[$request->status] ?? $request->status)
        );
    }
}