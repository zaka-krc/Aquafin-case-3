@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Bestelling Afronden</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium mb-4">Bestelde Materialen</h2>
                    
                    <div class="space-y-4">
                        @foreach($cart as $materialId => $item)
                            <div class="flex items-center border-b pb-4">
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
                    
                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between">
                            <span class="font-medium">Totaal aantal items:</span>
                            <span class="font-bold">{{ count($cart) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium mb-4">Levering Details</h2>
                    
                    <!-- Delivery Date -->
                    <div class="mb-4">
                        <label for="requested_delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Gewenste leveringsdatum <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="requested_delivery_date" 
                               name="requested_delivery_date" 
                               value="{{ old('requested_delivery_date', now()->addDays(2)->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('requested_delivery_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Delivery Location -->
                    <div class="mb-4">
                        <label for="delivery_location" class="block text-sm font-medium text-gray-700 mb-2">
                            Leveringslocatie
                        </label>
                        <input type="text" 
                               id="delivery_location" 
                               name="delivery_location" 
                               value="{{ old('delivery_location', 'Hoofdvestiging') }}"
                               placeholder="bv. Werkplaats, Magazijn, Projectlocatie..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('delivery_location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Opmerkingen
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3"
                                  placeholder="Speciale instructies, projectnummer, etc..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Bestelling Plaatsen
                        </button>
                        
                        <a href="{{ route('materials.cart') }}" 
                           class="block w-full text-center bg-gray-200 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-300">
                            Terug naar Winkelwagen
                        </a>
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
                                Leveringstijd
                            </h3>
                            <p class="mt-1 text-sm text-blue-700">
                                Bestellingen worden normaal binnen 1-2 werkdagen geleverd. 
                                Voor spoedleveringen, neem contact op met de magazijnbeheerder.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection