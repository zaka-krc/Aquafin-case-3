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

    // Bestelling opslaan
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

        // Bestelling aanmaken
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

        return redirect()->route('orders.show', $order)->with('success', 'Bestelling verzonden!');
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