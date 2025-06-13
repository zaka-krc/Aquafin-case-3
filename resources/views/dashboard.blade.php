@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Welkom bij Aquafin Materiaal Beheer
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Beheer en bestel eenvoudig al je benodigde materialen
        </p>
        
        <div class="space-x-4">
            <a href="{{ route('materials.index') }}" 
               class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-blue-700">
                Bekijk Voorraad
            </a>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-gray-700">
                    Admin Panel
                </a>
            @endif
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-8 mt-16 text-center">
        <div>
            <div class="text-3xl font-bold text-blue-600">{{ \App\Models\Material::count() }}</div>
            <div class="text-gray-600">Materialen</div>
        </div>
        <div>
            <div class="text-3xl font-bold text-green-600">{{ \App\Models\Category::count() }}</div>
            <div class="text-gray-600">Categorieën</div>
        </div>
        <div>
            <div class="text-3xl font-bold text-purple-600">{{ auth()->user()->orders()->count() }}</div>
            <div class="text-gray-600">Mijn Bestellingen</div>
        </div>
    </div>
</div>
@endsection