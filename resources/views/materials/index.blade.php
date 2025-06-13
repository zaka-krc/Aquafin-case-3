@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/4 pr-8">
            <h3 class="font-medium text-gray-900 mb-4">Filters</h3>
            
            <div class="space-y-2">
                @foreach($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded">
                        <span class="ml-2 text-sm">{{ $category->icon }} {{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-3/4">
            <h1 class="text-2xl font-bold mb-6">Voorraad</h1>

            <!-- Products Grid -->
            <div class="grid grid-cols-4 gap-6">
                @foreach($materials as $material)
                    <div class="bg-white border rounded-xl p-4 shadow hover:shadow-lg">
                        <!-- Image placeholder -->
                        <div class="w-full h-32 bg-gray-200 rounded mb-4"></div>
                        
                        <!-- Product info -->
                        <h3 class="font-medium mb-1">{{ $material->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $material->description }}</p>
                        <p class="text-xs text-blue-600 mb-4">{{ $material->category->name }}</p>

                        <!-- Add to cart -->
                        <form action="{{ route('materials.add-to-cart', $material) }}" method="POST">
                            @csrf
                            <div class="space-y-2">
                                <input type="number" name="quantity" value="1" min="1" 
                                       class="w-full px-2 py-1 border rounded">
                                <button type="submit" 
                                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                                    Toevoegen
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection