@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $material->name }}</h1>
            <p class="text-gray-600 mt-1">Materiaal Details & Beheer</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.materials') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Terug naar overzicht
            </a>
            <a href="{{ route('admin.materials.edit', $material) }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Bewerken
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Material Image & Basic Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Image -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            🖼️ Product Afbeelding
                        </h2>
                        <div class="bg-gray-100 rounded-lg aspect-square overflow-hidden">
                            <img src="{{ \App\Helpers\MaterialImageHelper::getImageUrl($material->name) }}" 
                                 alt="{{ $material->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center text-gray-400" style="display: none;">
                                <div class="text-center">
                                    <svg class="mx-auto h-16 w-16" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Geen afbeelding beschikbaar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Basic Material Info -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <span class="text-2xl mr-2">{{ $material->category->icon }}</span>
                            Materiaal Informatie
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Naam</dt>
                                <dd class="mt-1 text-lg font-medium text-gray-900">{{ $material->name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Categorie</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                          style="background-color: {{ $material->category->color }}20; color: {{ $material->category->color }};">
                                        {{ $material->category->icon }} {{ $material->category->name }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Eenheid</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $material->unit }}</dd>
                            </div>
                    
                    @if($material->description)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Beschrijving</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->description }}</dd>
                    </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Eenheid</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->unit }}</dd>
                    </div>
                    
                    @if($material->article_number)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Artikelnummer</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $material->article_number }}</dd>
                    </div>
                    @endif
                    
                    @if($material->supplier)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Leverancier</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->supplier }}</dd>
                    </div>
                    @endif
                    
                    @if($material->price)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prijs per {{ $material->unit }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">€ {{ number_format($material->price, 2, ',', '.') }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stock History (Recent Orders) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    📈 Recente Bestellingen
                </h2>
                
                @php
                    $recentOrders = $material->orderItems()
                        ->with(['order.user'])
                        ->whereHas('order', function($q) {
                            $q->where('status', '!=', 'cancelled');
                        })
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();
                @endphp
                
                @if($recentOrders->isNotEmpty())
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bestelling</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gebruiker</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aantal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $orderItem)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $orderItem->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('admin.orders.show', $orderItem->order) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                {{ $orderItem->order->order_number }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $orderItem->order->user->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $orderItem->quantity }} {{ $orderItem->unit }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'approved' => 'bg-blue-100 text-blue-800',
                                                    'processing' => 'bg-indigo-100 text-indigo-800',
                                                    'delivered' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$orderItem->order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($orderItem->order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="mt-2">Nog geen bestellingen voor dit materiaal</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stock Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">📊 Voorraad Status</h2>
                
                <!-- Current Stock Display -->
                <div class="text-center mb-6">
                    <div class="text-4xl font-bold mb-2 {{ $material->current_stock <= 0 ? 'text-red-600' : ($material->current_stock <= $material->minimum_stock ? 'text-yellow-600' : 'text-green-600') }}">
                        {{ $material->current_stock }}
                    </div>
                    <div class="text-sm text-gray-500">{{ $material->unit }} beschikbaar</div>
                    
                    <!-- Status Badge -->
                    @if($material->current_stock <= 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-2">
                            ❌ Niet op voorraad
                        </span>
                    @elseif($material->current_stock <= $material->minimum_stock)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-2">
                            ⚠️ Lage voorraad
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                            ✅ Op voorraad
                        </span>
                    @endif
                </div>
                
                <!-- Stock Info -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-sm text-gray-600">Minimum voorraad</span>
                        <span class="font-medium">{{ $material->minimum_stock }} {{ $material->unit }}</span>
                    </div>
                    
                    @if(!$material->is_available)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-sm text-red-800">
                                <strong>Let op:</strong> Dit materiaal is uitgeschakeld en niet zichtbaar voor gebruikers.
                            </p>
                        </div>
                    @endif
                </div>
                
                <!-- Quick Stock Update Form -->
                <form action="{{ route('admin.materials.update-stock', $material) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Snelle voorraad update
                    </label>
                    <div class="flex space-x-2">
                        <input type="number" 
                               name="current_stock" 
                               value="{{ $material->current_stock }}"
                               min="0"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               required>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">⚡ Acties</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.materials.edit', $material) }}" 
                       class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Materiaal Bewerken
                    </a>
                    
                    <!-- Delete with confirmation -->
                    <form action="{{ route('admin.materials.delete', $material) }}" 
                          method="POST" 
                          onsubmit="return confirm('Weet je zeker dat je dit materiaal wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">📊 Statistieken</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Totaal besteld</span>
                        <span class="font-medium">
                            {{ $material->orderItems->sum('quantity') }} {{ $material->unit }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Aantal bestellingen</span>
                        <span class="font-medium">
                            {{ $material->orderItems->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Gemiddeld per bestelling</span>
                        <span class="font-medium">
                            @if($material->orderItems->count() > 0)
                                {{ round($material->orderItems->sum('quantity') / $material->orderItems->count(), 1) }} {{ $material->unit }}
                            @else
                                0 {{ $material->unit }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection