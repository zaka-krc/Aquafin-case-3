@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Bestelling {{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">Geplaatst op {{ $order->created_at->format('d F Y \o\m H:i') }}</p>
            </div>
            <a href="{{ route('orders.index') }}" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Terug naar overzicht
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Bestelde Materialen</h2>
                
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="border-b pb-4 last:border-0">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ $item->material->name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->material->category->icon }} {{ $item->material->category->name }}
                                    </p>
                                    @if($item->material->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $item->material->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right ml-4">
                                    <p class="font-medium">{{ $item->quantity }} {{ $item->unit }}</p>
                                    @if($item->material->article_number)
                                        <p class="text-xs text-gray-500">Art.nr: {{ $item->material->article_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Totals -->
                <div class="mt-6 pt-4 border-t">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Totaal aantal items:</span>
                        <span class="font-medium">{{ $order->orderItems->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-2">
                        <span class="text-gray-600">Totaal aantal producten:</span>
                        <span class="font-medium">{{ $order->orderItems->sum('quantity') }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-lg font-medium mb-4">Opmerkingen</h2>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Status</h2>
                
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
                    $statusIcons = [
                        'pending' => '⏳',
                        'approved' => '✅',
                        'processing' => '📦',
                        'delivered' => '✓',
                        'cancelled' => '✗',
                    ];
                @endphp
                
                <div class="text-center p-4 rounded-lg border-2 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                    <div class="text-4xl mb-2">{{ $statusIcons[$order->status] ?? '?' }}</div>
                    <div class="font-medium text-lg">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </div>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Leveringsinformatie</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Gewenste leverdatum:</p>
                        <p class="font-medium">{{ $order->requested_delivery_date->format('d F Y') }}</p>
                        <p class="text-sm text-gray-500">
                            ({{ $order->requested_delivery_date->diffForHumans() }})
                        </p>
                    </div>
                    
                    @if($order->delivery_location)
                        <div>
                            <p class="text-sm text-gray-600">Leveringslocatie:</p>
                            <p class="font-medium">{{ $order->delivery_location }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Besteld door</h2>
                
                <div class="space-y-2">
                    <div>
                        <p class="text-sm text-gray-600">Naam:</p>
                        <p class="font-medium">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email:</p>
                        <p class="font-medium">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($order->status === 'pending')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Deze bestelling wacht nog op goedkeuring van de magazijnbeheerder.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection