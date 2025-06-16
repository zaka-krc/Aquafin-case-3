@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bestelling {{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-1">Bestelling details en status beheer</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Terug naar overzicht
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    📋 Bestelling Informatie
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Bestelnummer</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">{{ $order->order_number }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Besteldatum</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Klant</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="font-medium">{{ $order->user->name }}</div>
                            <div class="text-gray-600">{{ $order->user->email }}</div>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gewenste leverdatum</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->requested_delivery_date->format('d/m/Y') }}
                            @if($order->requested_delivery_date->isPast())
                                <span class="text-red-600 text-xs ml-2">⚠️ Verlopen</span>
                            @elseif($order->requested_delivery_date->isToday())
                                <span class="text-orange-600 text-xs ml-2 font-medium">📅 Vandaag!</span>
                            @elseif($order->requested_delivery_date->isTomorrow())
                                <span class="text-blue-600 text-xs ml-2">🔜 Morgen</span>
                            @endif
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Leverlocatie</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->delivery_location }}</dd>
                    </div>
                    
                    @if($order->notes)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Opmerkingen</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    📦 Bestelde Items
                </h2>
                
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Materiaal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categorie</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aantal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Beschikbaar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->material->name }}</div>
                                            @if($item->material->article_number)
                                                <div class="text-xs text-gray-500">Art.nr: {{ $item->material->article_number }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->material->category->icon }} {{ $item->material->category->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $item->quantity }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($item->material->current_stock >= $item->quantity)
                                            <span class="text-green-600">✅ {{ $item->material->current_stock }} {{ $item->material->unit }}</span>
                                        @else
                                            <span class="text-red-600">❌ {{ $item->material->current_stock }} {{ $item->material->unit }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Management -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">📊 Status Beheer</h2>
                
                <!-- Current Status -->
                <div class="text-center mb-6">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                            'delivered' => 'bg-green-100 text-green-800 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                        $statusLabels = [
                            'pending' => 'In afwachting',
                            'approved' => 'Goedgekeurd',
                            'processing' => 'In verwerking',
                            'delivered' => 'Geleverd',
                            'cancelled' => 'Geannuleerd',
                        ];
                    @endphp
                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border-2 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </div>
                </div>
                
                <!-- Status Update Form -->
                @if($order->status != 'delivered' && $order->status != 'cancelled')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status wijzigen naar:
                            </label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Selecteer nieuwe status</option>
                                @if($order->status == 'pending')
                                    <option value="approved">✅ Goedkeuren</option>
                                    <option value="cancelled">❌ Annuleren</option>
                                @endif
                                @if($order->status == 'approved')
                                    <option value="processing">🔄 In verwerking</option>
                                    <option value="cancelled">❌ Annuleren</option>
                                @endif
                                @if($order->status == 'processing')
                                    <option value="delivered">📦 Geleverd</option>
                                    <option value="cancelled">❌ Annuleren</option>
                                @endif
                            </select>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                onclick="return confirm('Weet je zeker dat je de status wilt wijzigen?')">
                            Status Bijwerken
                        </button>
                    </form>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">📊 Samenvatting</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Totaal items</span>
                        <span class="font-medium">{{ $order->orderItems->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Totaal stuks</span>
                        <span class="font-medium">{{ $order->orderItems->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Aangemaakt</span>
                        <span class="font-medium">{{ $order->created_at->format('d/m H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Laatste update</span>
                        <span class="font-medium">{{ $order->updated_at->format('d/m H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Workflow Info -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-blue-900 mb-2">📋 Workflow:</h3>
                <div class="text-xs text-blue-800 space-y-1">
                    <div class="{{ $order->status == 'pending' ? 'font-semibold' : '' }}">
                        1. 🟡 In afwachting → Admin goedkeuring
                    </div>
                    <div class="{{ $order->status == 'approved' ? 'font-semibold' : '' }}">
                        2. 🔵 Goedgekeurd → Magazijn voorbereiding
                    </div>
                    <div class="{{ $order->status == 'processing' ? 'font-semibold' : '' }}">
                        3. 🟣 In verwerking → Transport
                    </div>
                    <div class="{{ $order->status == 'delivered' ? 'font-semibold' : '' }}">
                        4. 🟢 Geleverd → Voltooid
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection