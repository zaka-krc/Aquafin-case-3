@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Beheer materialen, bestellingen en gebruikers</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Materials -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Totaal Materialen</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Material::count() }}</p>
                </div>
                <div class="text-blue-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Wachtende Bestellingen</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                </div>
                <div class="text-yellow-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Totaal Gebruikers</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="text-green-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Orders Today -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Bestellingen Vandaag</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</p>
                </div>
                <div class="text-purple-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Material Management -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Materiaal Beheer</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.materials') }}" 
                   class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">📦</span>
                        <div>
                            <p class="font-medium">Alle Materialen</p>
                            <p class="text-sm text-gray-600">Bekijk en beheer materialen</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('admin.materials.create') }}" 
                   class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">➕</span>
                        <div>
                            <p class="font-medium">Nieuw Materiaal</p>
                            <p class="text-sm text-gray-600">Voeg een nieuw materiaal toe</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Recente Bestellingen</h3>
                <a href="{{ route('admin.orders') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Bekijk alle →
                </a>
            </div>
            
            @php
                $recentOrders = \App\Models\Order::with('user')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($recentOrders->isEmpty())
                <p class="text-gray-500 text-center py-4">Nog geen bestellingen</p>
            @else
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 border rounded-lg">
                            <div>
                                <p class="font-medium">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->name }} - {{ $order->created_at->format('d/m H:i') }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-indigo-100 text-indigo-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Low Stock & Out of Stock Alerts -->
    @php
        $lowStockMaterials = \App\Models\Material::where('current_stock', '>', 0)
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->orderBy('current_stock')
            ->get();

        $outOfStockMaterials = \App\Models\Material::where('current_stock', 0)
            ->orderBy('name')
            ->get();
    @endphp

    @if($lowStockMaterials->isNotEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-yellow-900 mb-4">⚠️ Lage Voorraad</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($lowStockMaterials as $material)
                    <div class="bg-white rounded p-3">
                        <p class="font-medium">{{ $material->name }}</p>
                        <p class="text-sm text-gray-600">Voorraad: {{ $material->current_stock }} / Min: {{ $material->minimum_stock }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($outOfStockMaterials->isNotEmpty())
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-red-900 mb-4">❌ Niet op voorraad</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($outOfStockMaterials as $material)
                    <div class="bg-white rounded p-3">
                        <p class="font-medium">{{ $material->name }}</p>
                        <p class="text-sm text-gray-600">Voorraad: 0 / Min: {{ $material->minimum_stock }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection