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
                        <div class="w-20 h-20 bg-gray-200 rounded mr-6 flex items-center justify-center">
                            <span class="text-2xl">📦</span>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-medium">{{ $item['name'] }}</h3>
                            <p class="text-gray-600">{{ $item['category'] }}</p>
                            <p class="text-sm text-gray-500">{{ $item['quantity'] }} {{ $item['unit'] }}</p>
                        </div>

                        <form action="{{ route('materials.remove-from-cart', $materialId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach

                <!-- Summary -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="font-medium mb-4">📋 Bestelling Samenvatting</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Aantal verschillende items:</span>
                            <span class="font-medium">{{ count($cart) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Totaal aantal stuks:</span>
                            <span class="font-medium">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-1/3">
                <div class="bg-white border rounded-xl p-6">
                    <h3 class="text-lg font-medium mb-4">🛒 Bestelling info</h3>
                    
                    <div class="space-y-4">
                        <!-- Quick Delivery Date -->
                        <div>
                            <label for="delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Wanneer heb je dit nodig? 📅
                            </label>
                            <input type="date" 
                                   id="delivery_date"
                                   value="{{ now()->addDays(2)->format('Y-m-d') }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   max="{{ now()->addDays(30)->format('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500" id="date-info">
                                Standaard over 2 dagen
                            </p>
                        </div>

                        <!-- Continue Button -->
                        <a href="#" 
                           id="checkout-button"
                           class="block w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 text-center transition-colors">
                            Bestelling Afronden →
                        </a>

                        <!-- Quick Actions -->
                        <div class="pt-4 border-t space-y-2">
                            <a href="{{ route('materials.index') }}" 
                               class="block w-full text-center bg-gray-100 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-200 text-sm">
                                ➕ Meer items toevoegen
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                💡 Bestelling afronden
                            </h3>
                            <p class="mt-1 text-sm text-blue-700">
                                In de volgende stap kun je de leverlocatie en opmerkingen toevoegen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Update checkout button with delivery date
function updateCheckoutButton() {
    const deliveryDate = document.getElementById('delivery_date').value;
    const checkoutButton = document.getElementById('checkout-button');
    const dateInfo = document.getElementById('date-info');
    
    if (deliveryDate) {
        const selectedDate = new Date(deliveryDate);
        const today = new Date();
        const diffTime = selectedDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        checkoutButton.href = `{{ route('orders.create') }}?delivery_date=${deliveryDate}`;
        
        if (diffDays <= 1) {
            dateInfo.textContent = '⚡ Spoedlevering';
            dateInfo.className = 'mt-1 text-xs text-orange-600 font-medium';
        } else if (diffDays <= 2) {
            dateInfo.textContent = '🚀 Snelle levering';
            dateInfo.className = 'mt-1 text-xs text-yellow-600';
        } else {
            dateInfo.textContent = `✅ Over ${diffDays} dagen`;
            dateInfo.className = 'mt-1 text-xs text-green-600';
        }
    }
}

// Set initial checkout URL and add event listener
document.getElementById('delivery_date').addEventListener('change', updateCheckoutButton);
updateCheckoutButton(); // Set initial state
</script>
@endsection