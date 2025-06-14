@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('materials.index') }}" class="text-blue-600 hover:underline">Materialen</a></li>
            <li><span class="text-gray-500">/</span></li>
            <li><a href="{{ route('materials.index', ['category' => $material->category_id]) }}" class="text-blue-600 hover:underline">{{ $material->category->name }}</a></li>
            <li><span class="text-gray-500">/</span></li>
            <li class="text-gray-700">{{ $material->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <div class="bg-gray-200 rounded-lg aspect-square flex items-center justify-center">
                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>

        <!-- Product Info -->
        <div>
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $material->name }}</h1>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-blue-600">{{ $material->category->icon }} {{ $material->category->name }}</span>
                    @if($material->article_number)
                        <span class="text-gray-500">Art.nr: {{ $material->article_number }}</span>
                    @endif
                </div>
            </div>

            @if($material->description)
                <div class="mb-6">
                    <h2 class="text-lg font-medium mb-2">Beschrijving</h2>
                    <p class="text-gray-700">{{ $material->description }}</p>
                </div>
            @endif

            <!-- Voorraad Status -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-medium mb-3">Voorraad Informatie</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Huidige voorraad:</span>
                        <span class="font-medium">{{ $material->current_stock }} {{ $material->unit }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Minimum voorraad:</span>
                        <span class="font-medium">{{ $material->minimum_stock }} {{ $material->unit }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        @if($material->current_stock == 0)
                            <span class="text-red-600 font-medium">Niet op voorraad</span>
                        @elseif($material->current_stock <= $material->minimum_stock)
                            <span class="text-yellow-600 font-medium">Lage voorraad</span>
                        @else
                            <span class="text-green-600 font-medium">Op voorraad</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Add to Cart -->
            <form action="{{ route('materials.add-to-cart', $material) }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-end gap-4">
                    <div class="flex-1">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                            Aantal ({{ $material->unit }})
                        </label>
                        <input type="number" 
                               id="quantity"
                               name="quantity" 
                               value="1" 
                               min="1" 
                               max="{{ $material->current_stock > 0 ? $material->current_stock : 999 }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            {{ $material->current_stock == 0 ? 'disabled' : '' }}>
                        @if($material->current_stock == 0)
                            Niet beschikbaar
                        @else
                            Toevoegen aan winkelwagen
                        @endif
                    </button>
                </div>
            </form>

            <!-- Additional Info -->
            @if($material->supplier || $material->price)
                <div class="border-t pt-6">
                    <h3 class="font-medium mb-3">Aanvullende informatie</h3>
                    <dl class="space-y-2">
                        @if($material->supplier)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Leverancier:</dt>
                                <dd class="font-medium">{{ $material->supplier }}</dd>
                            </div>
                        @endif
                        @if($material->price)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Indicatieve prijs:</dt>
                                <dd class="font-medium">€ {{ number_format($material->price, 2, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedMaterials->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Gerelateerde materialen</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedMaterials as $related)
                    <a href="{{ route('materials.show', $related) }}" class="block">
                        <div class="bg-white border rounded-lg p-4 hover:shadow-lg transition-shadow">
                            <div class="bg-gray-200 rounded h-32 mb-3"></div>
                            <h3 class="font-medium text-sm mb-1">{{ $related->name }}</h3>
                            <p class="text-xs text-gray-600">{{ $related->current_stock }} {{ $related->unit }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection