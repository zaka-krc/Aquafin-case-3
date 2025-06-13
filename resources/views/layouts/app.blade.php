<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aquafin Materiaal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="text-2xl font-bold text-blue-600">
                    🌊 Aquafin
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Cart -->
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        <a href="{{ route('materials.cart') }}" class="relative bg-blue-100 p-2 rounded-lg">
                            🛒
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <span class="text-blue-600">{{ Auth::user()->name }}</span>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                Uitloggen
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Inloggen
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Menu -->
        @auth
        <div class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-8 py-4">
                    <a href="{{ route('home') }}" class="px-6 py-2 hover:bg-gray-700 rounded">HOME</a>
                    <a href="{{ route('materials.index') }}" class="px-6 py-2 hover:bg-gray-700 rounded">VOORRAAD</a>
                    <a href="#" class="px-6 py-2 hover:bg-gray-700 rounded">KITS</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 hover:bg-red-700 rounded bg-red-600">ADMIN</a>
                    @endif
                </div>
            </div>
        </div>
        @endauth
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Content -->
    <main>
        @yield('content')
    </main>
</body>
</html>