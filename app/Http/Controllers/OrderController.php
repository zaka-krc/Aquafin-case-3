<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Material;

class OrderController extends Controller
{
    // Bestelling maken form
    public function create()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('materials.index')->with('error', 'Winkelwagen is leeg!');
        }
        
        return view('orders.create', compact('cart'));
    }

    // Vervang alleen deze method in je OrderController:

    public function store(Request $request)
    {
        $request->validate([
            'requested_delivery_date' => 'required|date|after:today',
            'delivery_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('materials.index')->with('error', 'Winkelwagen is leeg!');
        }

        // 🔍 KRITIEKE VALIDATIE: Check voorraad vlak voor bestelling
        $stockErrors = [];
        foreach($cart as $item) {
            $material = Material::find($item['material_id']);
            
            if (!$material) {
                $stockErrors[] = "❌ '{$item['name']}' bestaat niet meer";
                continue;
            }
            
            if (!$material->is_available) {
                $stockErrors[] = "❌ '{$material->name}' is niet meer beschikbaar";
                continue;
            }
            
            if ($material->current_stock < $item['quantity']) {
                $stockErrors[] = "❌ '{$material->name}': gevraagd {$item['quantity']} {$item['unit']}, beschikbaar {$material->current_stock} {$material->unit}";
            }
        }
        
        // Als er voorraad problemen zijn, stop en toon errors
        if (!empty($stockErrors)) {
            return redirect()->route('materials.cart')->with('error', 
                'Voorraad problemen gevonden:<br>' . implode('<br>', $stockErrors) . 
                '<br><br>💡 <strong>Tip:</strong> Ga terug naar je winkelwagen om de hoeveelheden aan te passen.'
            );
        }

        // Bestelling aanmaken (alleen als alle voorraad OK is)
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'requested_delivery_date' => $request->requested_delivery_date,
            'delivery_location' => $request->delivery_location,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Order items aanmaken
        foreach($cart as $item) {
            $material = Material::find($item['material_id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'material_id' => $material->id,
                'quantity' => $item['quantity'],
                'unit' => $material->unit
            ]);
        }

        // Winkelwagen leegmaken
        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 
            "🎉 Bestelling {$order->order_number} succesvol verzonden! " .
            "Je krijgt bericht zodra deze is goedgekeurd."
        );
    }

    // Bestelling bekijken
    public function show(Order $order)
    {
        // Check of user eigenaar is van bestelling
        if($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load(['orderItems.material.category', 'user']);
        
        return view('orders.show', compact('order'));
    }

    // Mijn bestellingen
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('orders.index', compact('orders'));
    }
}