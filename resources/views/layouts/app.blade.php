<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Grand Luxe Hotel & Resort | Luxury Accommodations')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN for instant rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            50: '#FDFBF7',
                            100: '#F8F3EA',
                            200: '#EFE3CE',
                            300: '#E2CDA7',
                            400: '#D5B780',
                            500: '#C5A880',
                            600: '#B8935E',
                            700: '#9B7443',
                            800: '#7B5A33',
                            900: '#5F4426',
                        },
                        charcoal: {
                            800: '#1E293B',
                            900: '#0F172A',
                            950: '#090D16',
                        },
                        cream: '#FAF8F5',
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF8F5;
            color: #1E293B;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #C5A880 50%, #B8935E 100%);
        }
        .gold-text-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #B8935E 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border-gradient {
            border-image: linear-gradient(135deg, #D4AF37, #C5A880) 1;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-gold-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-gold-200/50 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full gold-gradient flex items-center justify-center text-white font-serif font-bold text-xl shadow-md shadow-gold-500/20 group-hover:scale-105 transition-transform">
                        L
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-xl sm:text-2xl font-bold tracking-wider text-charcoal-900 leading-none">GRAND LUXE</span>
                        <span class="text-[10px] tracking-[0.25em] text-gold-600 font-semibold uppercase mt-0.5">Hotel & Resort</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition-colors hover:text-gold-600 {{ request()->routeIs('home') ? 'text-gold-600 font-semibold border-b-2 border-gold-500 pb-1' : 'text-charcoal-800' }}">
                        Home
                    </a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-medium transition-colors hover:text-gold-600 {{ request()->routeIs('rooms.*') ? 'text-gold-600 font-semibold border-b-2 border-gold-500 pb-1' : 'text-charcoal-800' }}">
                        Rooms & Suites
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-medium transition-colors hover:text-gold-600 {{ request()->routeIs('about') ? 'text-gold-600 font-semibold border-b-2 border-gold-500 pb-1' : 'text-charcoal-800' }}">
                        About Hotel
                    </a>
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('my.reservations') }}" class="text-sm font-medium transition-colors hover:text-gold-600 {{ request()->routeIs('my.reservations') ? 'text-gold-600 font-semibold border-b-2 border-gold-500 pb-1' : 'text-charcoal-800' }}">
                                My Reservations
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Desktop Auth / CTA Controls -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs uppercase tracking-wider font-semibold rounded-lg bg-charcoal-900 text-gold-300 hover:bg-charcoal-800 transition-colors shadow-sm flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Admin Dashboard
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2.5 px-3 py-1.5 rounded-full border border-gold-200 bg-gold-50/50 hover:bg-gold-100/60 transition-colors">
                                <div class="w-8 h-8 rounded-full gold-gradient flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold text-charcoal-900 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-charcoal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gold-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-bold text-charcoal-900 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold uppercase rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-gold-100 text-gold-800' }}">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>

                                @if(!auth()->user()->isAdmin())
                                    <a href="{{ route('my.reservations') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-charcoal-800 hover:bg-gold-50 hover:text-gold-700">
                                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                        My Reservations
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-charcoal-800 hover:bg-gold-50 hover:text-gold-700">
                                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Dashboard
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-charcoal-900 hover:text-gold-600 transition-colors px-3 py-2">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold rounded-full gold-gradient text-white shadow-md shadow-gold-500/25 hover:shadow-lg hover:shadow-gold-500/40 hover:scale-[1.02] transition-all">
                            Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center gap-2 md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-charcoal-800 hover:bg-gold-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gold-200/60 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-charcoal-900 hover:bg-gold-50">Home</a>
            <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-lg font-medium text-charcoal-900 hover:bg-gold-50">Rooms & Suites</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-charcoal-900 hover:bg-gold-50">About Hotel</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg font-medium text-purple-700 bg-purple-50">Admin Dashboard</a>
                @else
                    <a href="{{ route('my.reservations') }}" class="block px-3 py-2 rounded-lg font-medium text-charcoal-900 hover:bg-gold-50">My Reservations</a>
                @endif
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full gold-gradient flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-semibold text-charcoal-900">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-600 font-semibold px-2 py-1 bg-red-50 rounded">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-gray-100 flex items-center gap-3">
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-sm font-semibold border border-gold-300 rounded-lg text-charcoal-900">Sign In</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center py-2 text-sm font-semibold gold-gradient text-white rounded-lg shadow">Register</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 no-print w-full">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center gap-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('info') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-in">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Please correct the following errors:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-charcoal-950 text-gray-300 pt-16 pb-12 border-t border-charcoal-800 no-print mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                
                <!-- Col 1: Brand & Bio -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full gold-gradient flex items-center justify-center text-white font-serif font-bold text-lg">
                            L
                        </div>
                        <div>
                            <span class="font-serif text-xl font-bold tracking-wider text-white">GRAND LUXE</span>
                            <span class="block text-[9px] tracking-[0.25em] text-gold-400 font-semibold uppercase">Hotel & Resort</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Where timeless elegance meets modern luxury. Immerse yourself in breathtaking suites, world-class dining, and bespoke hospitality.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="w-8 h-8 rounded-full bg-charcoal-800 hover:bg-gold-600 transition-colors flex items-center justify-center text-gray-300 hover:text-white cursor-pointer">
                            f
                        </span>
                        <span class="w-8 h-8 rounded-full bg-charcoal-800 hover:bg-gold-600 transition-colors flex items-center justify-center text-gray-300 hover:text-white cursor-pointer">
                            in
                        </span>
                        <span class="w-8 h-8 rounded-full bg-charcoal-800 hover:bg-gold-600 transition-colors flex items-center justify-center text-gray-300 hover:text-white cursor-pointer">
                            ig
                        </span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition-colors">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-gold-400 transition-colors">Rooms & Suites</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-gold-400 transition-colors">About Us</a></li>
                        @auth
                            <li><a href="{{ route('my.reservations') }}" class="hover:text-gold-400 transition-colors">My Reservations</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-gold-400 transition-colors">Login / Register</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Col 3: Accommodations -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-white mb-4">Suites & Villas</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('rooms.index', ['room_type' => 'Standard']) }}" class="hover:text-gold-400 transition-colors">Standard Cozy Rooms</a></li>
                        <li><a href="{{ route('rooms.index', ['room_type' => 'Deluxe']) }}" class="hover:text-gold-400 transition-colors">Deluxe City View</a></li>
                        <li><a href="{{ route('rooms.index', ['room_type' => 'Executive']) }}" class="hover:text-gold-400 transition-colors">Executive Club Suites</a></li>
                        <li><a href="{{ route('rooms.index', ['room_type' => 'Suite']) }}" class="hover:text-gold-400 transition-colors">Royal Presidential Penthouse</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Location -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-white mb-4">Concierge & Contact</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-gold-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Boulevard Raya No. 88, Marina Bay District, Jakarta 10110</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-gold-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+62 (021) 8899-LUXE (5893)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-gold-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>reservations@grandluxehotel.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-charcoal-800 text-center text-xs text-gray-400 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Grand Luxe Hotel & Resort. All rights reserved.</p>
                <p class="text-gray-400">Crafted for Luxury Hospitality Excellence</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
