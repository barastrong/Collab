<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Shopify') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="bg-white shadow-sm sticky top-0 z-50 transition-all duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center mr-10">
                            <a href="{{ route('index') }}" class="text-3xl font-bold text-green-600 hover:text-green-700 transition duration-300">
                                Shopify
                            </a>
                        </div>
                        <!-- Logo and Navigation Container -->
                        <div class="flex-1 flex justify-center items-center">
                        <a href="{{ route('index') }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-full transition duration-300">
                                            Home
                                        </a>
                                        <a href="{{ route('barang') }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-full transition duration-300">
                                            Products
                                        </a>
                                        <a href="{{ route('purchases.index') }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-full transition duration-300">
                                            My Orders
                                        </a>
                            <!-- Centered Navigation Links -->
                            <div class="hidden sm:flex space-x-8">
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-full transition duration-300">
                                            Admin Dashboard
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <!-- Auth Links -->
                        <div class="flex items-center space-x-4">
                            @guest
                                <a href="{{ route('login') }}" 
                                   class="text-gray-600 hover:text-green-600 px-4 py-2 text-sm font-medium transition duration-300">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="text-gray-600 hover:text-green-600 px-4 py-2 text-sm font-medium transition duration-300">
                                    Register
                                </a>
                            @else
                                <div class="relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-gray-600 bg-gray-50 hover:bg-gray-100 focus:outline-none transition duration-300">
                                                <div>{{ Auth::user()->name }}</div>
                                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                        <x-dropdown-link :href="route('tablebarang')" 
                                                           class="hover:text-green-600 transition duration-300">
                                                {{ __('Table Barang') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('profile.edit')" 
                                                           class="hover:text-green-600 transition duration-300">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                                               class="hover:text-green-600 transition duration-300">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow bg-white">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-100">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Brand Section -->
                        <div class="col-span-1 md:col-span-2">
                            <span class="text-2xl font-bold text-green-600">Shopify</span>
                            <p class="mt-4 text-gray-600 max-w-md">Your one-stop destination for all your shopping needs. Quality products, seamless experience.</p>
                            <div class="mt-6 flex space-x-6">
                                <a href="#" class="text-gray-400 hover:text-green-600 transition duration-300">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-green-600 transition duration-300">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Shop</h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-green-600 transition duration-300">New Arrivals</a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-green-600 transition duration-300">Best Sellers</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Support Links -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Support</h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-green-600 transition duration-300">Help Center</a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 hover:text-green-600 transition duration-300">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <p class="text-center text-gray-400">
                            © {{ date('Y') }} Shopify. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>