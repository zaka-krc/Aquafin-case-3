@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Winkelwagen</h1>

    @if(empty($cart))
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Je winkelwagen is leeg</p>
            <a href="{{ route('materials.index') }}" 
               class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded">
                Ga winkelen
            </a>
        </div>
    @else
        <div class="flex gap-8">
            <!-- Cart Items -->
            <div class="w-2/3 space-y-4">
                @foreach($cart as $materialId => $item)
                    <div class="bg-white border rounded-xl p-6 flex items-center">
                        <div class="w-20 h-20 bg-gray-200 rounded mr-6"></div>
                        
                        <div class="flex-1">
                            <h3 class="font-medium">{{ $item['name'] }}</h3>
                            <p class="text-gray-600">{{ $item['category'] }}</p>
                            <p class="text-sm text-gray-500">{{ $item['quantity'] }} {{ $item['unit'] }}</p>
                        </div>

                        <form action="{{ route('materials.remove-from-cart', $materialId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                Verwijderen
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="w-1/3">
                <div class="bg-white border rounded-xl p-6">
                    <h3 class="text-lg font-medium mb-4">Bestelling info</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Telefoon nr</label>
                            <input type="tel" class="w-full px-3 py-2 border rounded">
                        </div>

                        <a href="{{ route('orders.create') }}" 
                           class="w-full bg-blue-400 text-white py-3 px-4 rounded text-center block hover:bg-blue-500">
                            Bestellen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection