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
        $categories = Category::with('availableMaterials')->get();
        $selectedCategory = $request->get('category');
        
        $materials = Material::with('category')
            ->where('is_available', true)
            ->when($selectedCategory, function($query, $selectedCategory) {
                return $query->where('category_id', $selectedCategory);
            })
            ->get();

        return view('materials.index', compact('categories', 'materials', 'selectedCategory'));
    }

    // Materiaal details
    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    // Voeg materiaal toe aan winkelwagen (session)
    public function addToCart(Request $request, Material $material)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
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
        
        return redirect()->back()->with('success', 'Materiaal toegevoegd aan winkelwagen!');
    }

    // Winkelwagen bekijken
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('materials.cart', compact('cart'));
    }

    // Item uit winkelwagen verwijderen
    public function removeFromCart($materialId)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$materialId])) {
            unset($cart[$materialId]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item verwijderd uit winkelwagen!');
    }
}