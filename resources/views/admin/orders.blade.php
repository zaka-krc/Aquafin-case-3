@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Bestellingen Beheer</h1>
        <p class="text-gray-600 mt-1">Beheer en verwerk alle bestellingen</p>
    </div>

    <!-- Status Tabs -->
    <div class="flex space-x-1 mb-6 border-b">
        <a href="{{ route('admin.orders') }}" 
           class="px-4 py-2 pb-3 {{ !request('status') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            Alle ({{ \App\Models\Order::count() }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" 
           class="px-4 py-2 pb-3 {{ request('status') == 'pending' ? 'border-b-2 border-yellow-500 text-yellow-600' : 'text-gray-600 hover:text-gray-800' }}">
            <span class="inline-flex items-center">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                In afwachting ({{ \App\Models\Order::where('status', 'pending')->count() }})
            </span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'approved']) }}" 
           class="px-4 py-2 pb-3 {{ request('status') == 'approved' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <span class="inline-flex items-center">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                Goedgekeurd ({{ \App\Models\Order::where('status', 'approved')->count() }})
            </span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'processing']) }}" 
           class="px-4 py-2 pb-3 {{ request('status') == 'processing' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600 hover:text-gray-800' }}">
            <span class="inline-flex items-center">
                <span class="w-2 h-2 bg-indigo-400 rounded-full mr-2"></span>
                In verwerking ({{ \App\Models\Order::where('status', 'processing')->count() }})
            </span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" 
           class="px-4 py-2 pb-3 {{ request('status') == 'delivered' ? 'border-b-2 border-green-500 text-green-600' : 'text-gray-600 hover:text-gray-800' }}">
            <span class="inline-flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                Geleverd ({{ \App\Models\Order::where('status', 'delivered')->count() }})
            </span>
        </a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bestelling
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gebruiker
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Datum
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Leverdatum
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Items
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acties
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 {{ $order->status == 'pending' ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $order->order_number }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $order->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $order->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $order->requested_delivery_date->format('d/m/Y') }}
                            </div>
                            @if($order->requested_delivery_date->isPast())
                                <span class="text-xs text-red-600">Verlopen</span>
                            @elseif($order->requested_delivery_date->isToday())
                                <span class="text-xs text-orange-600 font-medium">Vandaag!</span>
                            @elseif($order->requested_delivery_date->isTomorrow())
                                <span class="text-xs text-blue-600">Morgen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $order->orderItems->count() }} items
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $order->orderItems->sum('quantity') }} stuks
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-indigo-100 text-indigo-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'In afwachting',
                                    'approved' => 'Goedgekeurd',
                                    'processing' => 'In verwerking',
                                    'delivered' => 'Geleverd',
                                    'cancelled' => 'Geannuleerd',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <!-- View details -->
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Bekijk details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Quick approve for pending orders -->
                                @if($order->status == 'pending')
                                    <form action="{{ route('admin.orders.update-status', $order) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Goedkeuren? Dit vermindert de voorraad!');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900"
                                                title="Goedkeuren">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            Geen bestellingen gevonden
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
    
    <!-- Legend -->
    <div class="mt-6 bg-gray-50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 mb-2">Workflow uitleg:</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <div>• <strong>In afwachting</strong> → Admin moet goedkeuren → <strong>Goedgekeurd</strong> (voorraad wordt verminderd)</div>
            <div>• <strong>Goedgekeurd</strong> → Magazijn bereidt voor → <strong>In verwerking</strong></div>
            <div>• <strong>In verwerking</strong> → Levering voltooid → <strong>Geleverd</strong></div>
        </div>
    </div>
</div>
@endsection