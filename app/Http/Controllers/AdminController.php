<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Category;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        $totalMaterials = Material::count();
        $totalCategories = Category::count();
        
        return view('admin.dashboard', compact('totalMaterials', 'totalCategories'));
    }

    // Materialen overzicht voor admin
    public function materials()
    {
        $materials = Material::with('category')->get();
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
            'description' => 'nullable|string'
        ]);

        Material::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'unit' => $request->unit,
            'is_available' => true
        ]);

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
            'description' => 'nullable|string'
        ]);

        $material->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'unit' => $request->unit
        ]);

        return redirect()->route('admin.materials')->with('success', 'Materiaal bijgewerkt!');
    }

    // Materiaal verwijderen (soft delete)
    public function deleteMaterial(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials')->with('success', 'Materiaal verwijderd!');
    }
}