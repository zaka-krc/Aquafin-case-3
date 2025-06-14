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