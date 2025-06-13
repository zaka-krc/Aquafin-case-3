<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aquafin - Materiaal Beheer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <!-- Logo -->
            <div class="mb-6">
                <div class="text-4xl font-bold text-blue-600 flex items-center">
                    🌊 Aquafin
                </div>
                <p class="text-center text-gray-600 mt-2">Materiaal Beheer Systeem</p>
            </div>

            <!-- Content -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <!-- Test Credentials -->
            <div class="mt-6 p-4 bg-white rounded-lg shadow-md max-w-md w-full">
                <h3 class="font-medium text-gray-900 mb-2 text-center">Test Accounts:</h3>
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex justify-between">
                        <span><strong>Admin:</strong></span> 
                        <span>admin@aquafin.be / password</span>
                    </div>
                    <div class="flex justify-between">
                        <span><strong>User:</strong></span> 
                        <span>jan@aquafin.be / password</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>