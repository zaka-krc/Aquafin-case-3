@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex gap-8">
        <!-- Sidebar -->
        <div class="w-1/4">
            <h3 class="font-medium text-gray-900 mb-4">Filters</h3>
            
            <!-- Zoekbalk -->
            <form method="GET" action="{{ route('materials.index') }}" class="mb-6">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Zoek materiaal..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <input type="hidden" name="category" value="{{ request('category') }}">
            </form>
            
            <!-- Categorieën Filter -->
            <div class="space-y-2">
                <a href="{{ route('materials.index', ['search' => request('search')]) }}" 
                   class="block px-3 py-2 rounded {{ !request('category') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                    Alle categorieën
                </a>
                
                @foreach($categories as $category)
                    <a href="{{ route('materials.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                       class="block px-3 py-2 rounded {{ request('category') == $category->id ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                        <span class="text-sm">{{ $category->icon }} {{ $category->name }}</span>
                        <span class="text-xs text-gray-500">({{ $category->materials->count() }})</span>
                    </a>
                @endforeach
            </div>
            
            <!-- Beschikbaarheid Filter -->
            <div class="mt-6">
                <h4 class="font-medium text-sm text-gray-700 mb-3">Voorraad Status</h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" checked disabled class="rounded text-green-500">
                        <span class="ml-2 text-sm">Op voorraad</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" disabled class="rounded text-yellow-500">
                        <span class="ml-2 text-sm">Lage voorraad</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">
                    Materialen Voorraad
                    @if(request('search'))
                        <span class="text-base font-normal text-gray-600">- Zoekresultaten voor "{{ request('search') }}"</span>
                    @endif
                </h1>
                <div class="text-sm text-gray-600">
                    {{ $materials->count() }} materialen gevonden
                </div>
            </div>

            @if($materials->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-gray-500">Geen materialen gevonden.</p>
                    <a href="{{ route('materials.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">
                        Reset filters
                    </a>
                </div>
            @else
                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($materials as $material)
                        <div class="bg-white border rounded-xl shadow hover:shadow-lg transition-shadow">
                            <!-- Klikbare kaart voor details -->
                            <a href="{{ route('materials.show', $material) }}" class="block p-4">
                                <!-- Image placeholder met voorraad indicator -->
                                <div class="w-full h-32 bg-gray-200 rounded mb-4 relative">
                                    @if($material->current_stock <= $material->minimum_stock)
                                        <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                            Lage voorraad
                                        </span>
                                    @elseif($material->current_stock == 0)
                                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                            Niet op voorraad
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Product info -->
                                <h3 class="font-medium mb-1 text-gray-900">{{ $material->name }}</h3>
                                @if($material->description)
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $material->description }}</p>
                                @endif
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs text-blue-600">{{ $material->category->icon }} {{ $material->category->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $material->current_stock }} {{ $material->unit }}</p>
                                </div>
                                @if($material->article_number)
                                    <p class="text-xs text-gray-400">Art.nr: {{ $material->article_number }}</p>
                                @endif
                            </a>

                            <!-- Add to cart form -->
                            <div class="border-t px-4 pb-4 pt-3">
                                <form action="{{ route('materials.add-to-cart', $material) }}" method="POST">
                                    @csrf
                                    <div class="flex gap-2">
                                        <input type="number" 
                                               name="quantity" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $material->current_stock > 0 ? $material->current_stock : 999 }}"
                                               class="w-20 px-2 py-1 border rounded text-center">
                                        <button type="submit" 
                                                class="flex-1 bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-600 text-sm"
                                                {{ $material->current_stock == 0 ? 'disabled' : '' }}>
                                            @if($material->current_stock == 0)
                                                Niet beschikbaar
                                            @else
                                                Toevoegen
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection