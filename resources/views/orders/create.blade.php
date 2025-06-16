@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">🛒 Bestelling Afronden</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium mb-4 flex items-center">
                        <span class="text-2xl mr-2">📦</span>
                        Bestelde Materialen
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($cart as $materialId => $item)
                            <div class="flex items-center border-b pb-4 last:border-0">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg mr-4 flex items-center justify-center">
                                    <span class="text-lg">📦</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item['category'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">{{ $item['quantity'] }} {{ $item['unit'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 pt-4 border-t bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Aantal items:</span>
                                <span class="font-medium">{{ count($cart) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Totaal stuks:</span>
                                <span class="font-medium">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium mb-4 flex items-center">
                        <span class="text-2xl mr-2">🚚</span>
                        Levering Details
                    </h2>
                    
                    <!-- Delivery Date -->
                    <div class="mb-4">
                        <label for="requested_delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Gewenste leveringsdatum <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="requested_delivery_date" 
                               name="requested_delivery_date" 
                               value="{{ old('requested_delivery_date', request('delivery_date', now()->addDays(2)->format('Y-m-d'))) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               max="{{ now()->addDays(30)->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('requested_delivery_date') border-red-300 @enderror"
                               required>
                        @error('requested_delivery_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500" id="delivery-info">
                                @if(request('delivery_date'))
                                    Gekozen in winkelwagen: {{ \Carbon\Carbon::parse(request('delivery_date'))->format('d/m/Y') }}
                                @else
                                    Minimaal {{ now()->addDay()->format('d/m/Y') }}
                                @endif
                            </p>
                        @enderror
                    </div>

                    <!-- Delivery Location -->
                    <div class="mb-4">
                        <label for="delivery_location" class="block text-sm font-medium text-gray-700 mb-2">
                            Leveringslocatie <span class="text-red-500">*</span>
                        </label>
                        <select id="delivery_location" 
                                name="delivery_location" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('delivery_location') border-red-300 @enderror"
                                required>
                            <option value="">Kies een leverlocatie...</option>
                            <option value="Hoofdvestiging" {{ old('delivery_location', 'Hoofdvestiging') == 'Hoofdvestiging' ? 'selected' : '' }}>🏢 Hoofdvestiging</option>
                            <option value="Werkplaats" {{ old('delivery_location') == 'Werkplaats' ? 'selected' : '' }}>🔧 Werkplaats</option>
                            <option value="Magazijn" {{ old('delivery_location') == 'Magazijn' ? 'selected' : '' }}>📦 Magazijn</option>
                            <option value="Projectlocatie" {{ old('delivery_location') == 'Projectlocatie' ? 'selected' : '' }}>🚧 Projectlocatie</option>
                            <option value="Servicewagen" {{ old('delivery_location') == 'Servicewagen' ? 'selected' : '' }}>🚐 Servicewagen</option>
                            <option value="Anders" {{ old('delivery_location') == 'Anders' ? 'selected' : '' }}>📍 Anders</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Waar moeten de materialen geleverd worden?
                        </p>
                        @error('delivery_location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Opmerkingen en speciale instructies
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="4"
                                  placeholder="Bijvoorbeeld:&#10;• Projectnummer: P2025-001&#10;• Contactpersoon ter plaatse: Jan de Vries&#10;• Speciale toegangsinstructies&#10;• Urgentie/prioriteit"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-300 @enderror">{{ old('notes', request('notes')) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            Alles wat nuttig is voor een succesvolle levering
                        </p>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            ✅ Bestelling Plaatsen
                        </button>
                        
                        <a href="{{ route('materials.cart') }}" 
                           class="block w-full text-center bg-gray-200 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-300 transition-colors">
                            ← Terug naar Winkelwagen
                        </a>
                    </div>
                </div>

                <!-- Urgency Info -->
                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4" id="urgency-info" style="display: none;">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                ⚡ Spoedlevering
                            </h3>
                            <p class="mt-1 text-sm text-yellow-700">
                                Je hebt een korte levertijd geselecteerd. Vermeld dit in de opmerkingen voor prioriteit behandeling.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Standard Info -->
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                📋 Proces na bestelling
                            </h3>
                            <div class="mt-1 text-sm text-blue-700 space-y-1">
                                <p>1. ⏳ Bestelling wacht op goedkeuring</p>
                                <p>2. ✅ Admin controleert en keurt goed</p>
                                <p>3. 📦 Magazijn bereidt bestelling voor</p>
                                <p>4. 🚚 Levering naar opgegeven locatie</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Update delivery info based on selected date
document.getElementById('requested_delivery_date').addEventListener('change', function() {
    const selectedDate = new Date(this.value);
    const today = new Date();
    const diffTime = selectedDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    const infoElement = document.getElementById('delivery-info');
    const urgencyInfo = document.getElementById('urgency-info');
    
    if (diffDays <= 1) {
        infoElement.textContent = '⚡ Spoedlevering - Vermeld urgentie in opmerkingen';
        infoElement.className = 'mt-1 text-xs text-orange-600 font-medium';
        urgencyInfo.style.display = 'block';
    } else if (diffDays <= 2) {
        infoElement.textContent = '🚀 Snelle levering - Controleer beschikbaarheid';
        infoElement.className = 'mt-1 text-xs text-yellow-600 font-medium';
        urgencyInfo.style.display = 'block';
    } else if (diffDays <= 5) {
        infoElement.textContent = '✅ Normale levering';
        infoElement.className = 'mt-1 text-xs text-blue-600';
        urgencyInfo.style.display = 'none';
    } else {
        infoElement.textContent = `✅ Ruime planning (${diffDays} dagen)`;
        infoElement.className = 'mt-1 text-xs text-green-600';
        urgencyInfo.style.display = 'none';
    }
});

// Trigger on page load
document.getElementById('requested_delivery_date').dispatchEvent(new Event('change'));
</script>
@endsection