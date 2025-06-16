<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;

class MaterialController extends Controller
{
    // Materialen overzicht voor users
    public function index(Request $request)
    {
        $categories = Category::with('materials')->get();
        
        $query = Material::with('category')->where('is_available', true);
        
        // Filter op categorie
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Zoek functionaliteit
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        // Voorraad filter
        if ($request->has('stock') && $request->stock != 'all') {
            switch($request->stock) {
                case 'available':
                    $query->where('current_stock', '>', function($q) {
                        $q->select('minimum_stock')
                          ->from('materials as m2')
                          ->whereColumn('m2.id', 'materials.id');
                    });
                    break;
                case 'low':
                    $query->whereColumn('current_stock', '<=', 'minimum_stock')
                          ->where('current_stock', '>', 0);
                    break;
                case 'out':
                    $query->where('current_stock', 0);
                    break;
            }
        }
        
        $materials = $query->get();

        return view('materials.index', compact('categories', 'materials'));
    }

    // Materiaal details
    public function show(Material $material)
    {
        $material->load('category');
        $relatedMaterials = Material::where('category_id', $material->category_id)
            ->where('id', '!=', $material->id)
            ->where('is_available', true)
            ->take(4)
            ->get();
            
        return view('materials.show', compact('material', 'relatedMaterials'));
    }

        // Vervang alleen deze method in je MaterialController:

    public function cart()
    {
            $cart = session()->get('cart', []);
            return view('materials.cart', compact('cart'));
        }


    public function addToCart(Request $request, Material $material)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Check 1: Is materiaal beschikbaar?
        if (!$material->is_available) {
            return redirect()->back()->with('error', 'Dit materiaal is momenteel niet beschikbaar.');
        }

        // Check 2: Is er voorraad?
        if ($material->current_stock <= 0) {
            return redirect()->back()->with('error', 'Dit materiaal is niet op voorraad.');
        }

        $cart = session()->get('cart', []);
        
        // Check 3: Bereken totale hoeveelheid (bestaand in cart + nieuw)
        $currentCartQuantity = isset($cart[$material->id]) ? $cart[$material->id]['quantity'] : 0;
        $totalWanted = $currentCartQuantity + $request->quantity;
        
        // Check 4: Is totale hoeveelheid beschikbaar?
        if ($totalWanted > $material->current_stock) {
            if ($currentCartQuantity > 0) {
                return redirect()->back()->with('error', 
                    "❌ Te veel gevraagd! Je hebt al {$currentCartQuantity} {$material->unit} in je winkelwagen. " .
                    "Totaal gevraagd zou worden: {$totalWanted} {$material->unit}. " .
                    "Beschikbaar: {$material->current_stock} {$material->unit}."
                );
            } else {
                return redirect()->back()->with('error', 
                    "❌ Onvoldoende voorraad. Gevraagd: {$request->quantity} {$material->unit}, " .
                    "beschikbaar: {$material->current_stock} {$material->unit}."
                );
            }
        }
        
        // Check 5: Is gevraagde hoeveelheid niet te veel?
        if ($request->quantity > $material->current_stock) {
            return redirect()->back()->with('error', 
                "❌ Onvoldoende voorraad. Beschikbaar: {$material->current_stock} {$material->unit}"
            );
        }
        
        // Alles OK - voeg toe aan cart
        if(isset($cart[$material->id])) {
            $cart[$material->id]['quantity'] += $request->quantity;
        } else {
            $cart[$material->id] = [
                'material_id' => $material->id,
                'name' => $material->name,
                'unit' => $material->unit,
                'quantity' => $request->quantity,
                'category' => $material->category->name
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 
            "✅ {$request->quantity} {$material->unit} {$material->name} toegevoegd! " .
            "(Totaal in winkelwagen: {$cart[$material->id]['quantity']} {$material->unit})"
        );
    }
}