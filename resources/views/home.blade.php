@extends('layouts.app')

@section('title', 'Grand Luxe Hotel & Resort | Experience Timeless Luxury')

@section('content')
<!-- 1. HERO SECTION -->
<section class="relative min-h-[90vh] flex items-center justify-center bg-charcoal-950 text-white overflow-hidden">
    <!-- Hero Background Image with Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=2000&q=85" alt="Luxury Hotel Resort" class="w-full h-full object-cover object-center scale-105 animate-pulse duration-1000 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-charcoal-950 via-charcoal-950/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-charcoal-950/80 via-transparent to-charcoal-950/80"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center flex flex-col items-center">
        
        <!-- Luxury Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-gold-400/30 text-gold-300 text-xs font-semibold uppercase tracking-[0.25em] mb-6 shadow-lg">
            <span>★</span> Five-Star World Class Luxury Resort <span>★</span>
        </div>

        <!-- Headline -->
        <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white max-w-4xl leading-[1.15] mb-6">
            Find Your <span class="gold-text-gradient italic">Perfect Stay</span>
        </h1>

        <!-- Subheadline -->
        <p class="text-base sm:text-xl text-gray-300 max-w-2xl font-light leading-relaxed mb-10">
            Experience comfort, luxury, and unforgettable moments at Grand Luxe Hotel & Resort. Crafted for discerning travelers.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-4 mb-16">
            <a href="#search-card" class="px-8 py-4 rounded-full gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-gold-500/30 hover:scale-105 transition-all">
                Explore Rooms
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 text-white font-semibold text-sm uppercase tracking-wider border border-white/20 transition-all">
                Our Story
            </a>
        </div>

        <!-- Search Booking Card (Hero Widget) -->
        <div id="search-card" class="w-full max-w-5xl bg-white/95 backdrop-blur-xl rounded-3xl p-4 sm:p-6 shadow-2xl border border-gold-200/80 text-charcoal-900 text-left">
            <form method="GET" action="{{ route('rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                
                <!-- Check-in -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Check-in
                    </label>
                    <input type="date" name="check_in" value="{{ $defaultCheckIn }}" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors bg-white">
                </div>

                <!-- Check-out -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Check-out
                    </label>
                    <input type="date" name="check_out" value="{{ $defaultCheckOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors bg-white">
                </div>

                <!-- Adults -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Adults
                    </label>
                    <select name="adults" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors bg-white">
                        <option value="1">1 Adult</option>
                        <option value="2" selected>2 Adults</option>
                        <option value="3">3 Adults</option>
                        <option value="4">4 Adults</option>
                    </select>
                </div>

                <!-- Children -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Children
                    </label>
                    <select name="children" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors bg-white">
                        <option value="0" selected>0 Children</option>
                        <option value="1">1 Child</option>
                        <option value="2">2 Children</option>
                        <option value="3">3 Children</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div>
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-gold-500/25 hover:shadow-xl hover:shadow-gold-500/40 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Search Room
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<!-- 2. FEATURED ROOMS SECTION -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">Exclusive Accommodations</span>
        <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal-900 mt-2 mb-4">Featured Rooms</h2>
        <p class="text-gray-500 text-sm sm:text-base leading-relaxed">
            Choose the perfect room for your stay. Handcrafted interiors with world-class amenities for an unforgettable escape.
        </p>
    </div>

    <!-- Dynamic Room Grid: 4 cards on desktop, 2 on tablet, 1 on mobile -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($featuredRooms as $room)
            <div class="bg-white rounded-3xl overflow-hidden border border-gold-200/60 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col group hover:-translate-y-1.5">
                
                <!-- Room Image with Badge -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-charcoal-900 uppercase tracking-wider shadow-sm">
                            {{ $room->room_type }}
                        </span>
                    </div>

                    <div class="absolute bottom-3 left-3 text-gold-400 text-xs flex items-center gap-1 font-bold">
                        <span>★★★★★</span>
                        <span class="text-white text-[11px] font-normal ml-1">5.0</span>
                    </div>
                </div>

                <!-- Room Content -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-charcoal-900 group-hover:text-gold-700 transition-colors">
                            {{ $room->name }}
                        </h3>

                        <!-- Specs (Capacity & Bed) -->
                        <div class="flex items-center gap-4 text-xs text-gray-500 mt-2 mb-3">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $room->capacity }} Guests
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                {{ $room->bed_type }}
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                            {{ $room->description }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <!-- Price -->
                        <div class="mb-4">
                            <span class="text-xs text-gray-400">Starts from</span>
                            <div class="flex items-baseline gap-1">
                                <span class="font-serif text-xl font-bold text-charcoal-900">{{ $room->formatted_price }}</span>
                                <span class="text-xs text-gray-500 font-medium">/ night</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('rooms.show', $room->id) }}" class="py-2.5 px-3 text-center text-xs font-bold rounded-xl border border-gold-300 text-gold-800 hover:bg-gold-50 transition-colors">
                                View Detail
                            </a>
                            <a href="{{ route('booking.create', ['room_id' => $room->id, 'check_in' => $defaultCheckIn, 'check_out' => $defaultCheckOut]) }}" class="py-2.5 px-3 text-center text-xs font-bold rounded-xl gold-gradient text-white shadow hover:shadow-md transition-all">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-500">
                No rooms currently available. Please check back later.
            </div>
        @endforelse
    </div>

    <!-- View All Rooms Button -->
    <div class="text-center mt-14">
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full border-2 border-charcoal-900 text-charcoal-900 hover:bg-charcoal-900 hover:text-white font-bold text-sm uppercase tracking-wider transition-all">
            <span>Explore All Accommodations</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>
</section>

<!-- 3. HOTEL FACILITIES ("Everything You Need") -->
<section class="py-24 bg-white border-y border-gold-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">Unmatched Amenities</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal-900 mt-2 mb-4">Everything You Need</h2>
            <p class="text-gray-500 text-sm sm:text-base leading-relaxed">
                Enjoy world-class hotel amenities carefully tailored to bring you ultimate relaxation, leisure, and culinary delight.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Facility 1: WiFi Gratis -->
            <div class="p-8 rounded-3xl bg-cream border border-gold-100/80 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl gold-gradient flex items-center justify-center text-white text-2xl shadow-lg shadow-gold-500/20 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-charcoal-900 mb-2">High-Speed Wi-Fi</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Seamless gigabit internet coverage across all suites, beach lounges, and private cabanas.
                </p>
            </div>

            <!-- Facility 2: Breakfast -->
            <div class="p-8 rounded-3xl bg-cream border border-gold-100/80 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl gold-gradient flex items-center justify-center text-white text-2xl shadow-lg shadow-gold-500/20 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-charcoal-900 mb-2">Gourmet Breakfast</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Daily artisanal buffet and a la carte international breakfast prepared by Michelin-trained executive chefs.
                </p>
            </div>

            <!-- Facility 3: Swimming Pool -->
            <div class="p-8 rounded-3xl bg-cream border border-gold-100/80 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl gold-gradient flex items-center justify-center text-white text-2xl shadow-lg shadow-gold-500/20 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-charcoal-900 mb-2">Infinity Pool</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Heated panoramic infinity pool overlooking the ocean with poolside cocktail service & private sunbeds.
                </p>
            </div>

            <!-- Facility 4: 24/7 Service -->
            <div class="p-8 rounded-3xl bg-cream border border-gold-100/80 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl gold-gradient flex items-center justify-center text-white text-2xl shadow-lg shadow-gold-500/20 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-charcoal-900 mb-2">24/7 Concierge</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Round-the-clock dedicated butler assistance, in-room dining, airport luxury transfers, and excursion booking.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 4. ABOUT HOTEL ("Stay. Relax. Enjoy.") -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Images Composition -->
        <div class="relative">
            <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80" alt="Resort Architecture" class="w-full h-[450px] object-cover">
            </div>
            <div class="absolute -bottom-8 -right-6 w-48 sm:w-64 rounded-2xl overflow-hidden shadow-2xl border-4 border-white hidden sm:block">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80" alt="Luxury Suite Interior" class="w-full h-44 object-cover">
            </div>
            <div class="absolute -top-6 -left-6 p-4 rounded-2xl bg-charcoal-900 text-white shadow-xl flex items-center gap-3">
                <span class="font-serif text-3xl font-bold text-gold-400">25+</span>
                <span class="text-xs text-gray-300 leading-tight">Years of<br>Excellence</span>
            </div>
        </div>

        <!-- Content -->
        <div>
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">The Grand Luxe Experience</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal-900 mt-2 mb-6 leading-tight">
                Stay. Relax. Enjoy.
            </h2>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                Nestled along pristine coastlines, Grand Luxe Hotel & Resort is an iconic sanctuary designed to offer timeless luxury and pure rejuvenation. Every suite combines bespoke craftsmanship with the finest contemporary luxuries.
            </p>
            <div class="grid grid-cols-2 gap-6 mb-8 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center font-bold">✓</div>
                    <span class="font-semibold text-charcoal-900">Award-Winning Dining</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center font-bold">✓</div>
                    <span class="font-semibold text-charcoal-900">Holistic Wellness Spa</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center font-bold">✓</div>
                    <span class="font-semibold text-charcoal-900">Private Beach Access</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center font-bold">✓</div>
                    <span class="font-semibold text-charcoal-900">VIP Chauffeur Service</span>
                </div>
            </div>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-gold-500/25 hover:scale-105 transition-all">
                <span>Explore More</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- 5. WHY CHOOSE US ("Why Stay With Us?") -->
<section class="py-24 bg-charcoal-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Signature Hospitality</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-white mt-2 mb-4">Why Stay With Us?</h2>
            <p class="text-gray-400 text-sm sm:text-base leading-relaxed">
                Discover why over 50,000 international guests choose Grand Luxe as their premier hotel destination every year.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Reason 1: Best Price -->
            <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-gold-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-gold-500/20 text-gold-400 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-gold-500 group-hover:text-white transition-colors">
                    01
                </div>
                <h3 class="font-serif text-xl font-bold text-white mb-2">Best Price Guarantee</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Direct booking guarantees you our lowest price per night, exclusive perks, and flexible cancellation policies.
                </p>
            </div>

            <!-- Reason 2: Comfortable Rooms -->
            <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-gold-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-gold-500/20 text-gold-400 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-gold-500 group-hover:text-white transition-colors">
                    02
                </div>
                <h3 class="font-serif text-xl font-bold text-white mb-2">Comfortable Rooms</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Orthopedic luxury bedding, soundproof suites, and personalized climate controls ensure your deepest restful sleep.
                </p>
            </div>

            <!-- Reason 3: Great Location -->
            <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-gold-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-gold-500/20 text-gold-400 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-gold-500 group-hover:text-white transition-colors">
                    03
                </div>
                <h3 class="font-serif text-xl font-bold text-white mb-2">Prime Location</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Centrally situated near luxury boutiques, cultural landmarks, marina bay walks, and international airports.
                </p>
            </div>

            <!-- Reason 4: 24/7 Service -->
            <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-gold-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-gold-500/20 text-gold-400 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-gold-500 group-hover:text-white transition-colors">
                    04
                </div>
                <h3 class="font-serif text-xl font-bold text-white mb-2">24/7 Dedicated Care</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Our multi-lingual hospitality team is dedicated to fulfilling your custom requests at any hour of the day or night.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 6. TESTIMONIALS ("What Our Guests Say") -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">Guest Experiences</span>
        <h2 class="font-serif text-3xl sm:text-5xl font-bold text-charcoal-900 mt-2 mb-4">What Our Guests Say</h2>
        <p class="text-gray-500 text-sm sm:text-base leading-relaxed">
            Real stories from travelers around the globe who experienced the magic of Grand Luxe.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div class="p-8 rounded-3xl bg-white border border-gold-200/60 shadow-lg flex flex-col justify-between">
            <div>
                <div class="text-gold-500 text-lg mb-4">★★★★★</div>
                <p class="text-xs sm:text-sm text-gray-600 italic leading-relaxed mb-6">
                    "The Royal Suite was beyond breathtaking. From the private jacuzzi view to the attentive butler service, Grand Luxe sets a new benchmark for five-star hotels."
                </p>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Sarah Jenkins" class="w-11 h-11 rounded-full object-cover border-2 border-gold-400">
                <div>
                    <h4 class="font-bold text-xs text-charcoal-900">Sarah Jenkins</h4>
                    <p class="text-[11px] text-gray-400">London, United Kingdom</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="p-8 rounded-3xl bg-white border border-gold-200/60 shadow-lg flex flex-col justify-between">
            <div>
                <div class="text-gold-500 text-lg mb-4">★★★★★</div>
                <p class="text-xs sm:text-sm text-gray-600 italic leading-relaxed mb-6">
                    "Seamless booking process and pristine room condition. The breakfast buffet alone is worth the trip! Can't wait to return for our anniversary."
                </p>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Michael Chang" class="w-11 h-11 rounded-full object-cover border-2 border-gold-400">
                <div>
                    <h4 class="font-bold text-xs text-charcoal-900">Michael Chang</h4>
                    <p class="text-[11px] text-gray-400">Singapore</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="p-8 rounded-3xl bg-white border border-gold-200/60 shadow-lg flex flex-col justify-between">
            <div>
                <div class="text-gold-500 text-lg mb-4">★★★★★</div>
                <p class="text-xs sm:text-sm text-gray-600 italic leading-relaxed mb-6">
                    "Our family stayed in the Executive Club room. The kids loved the infinity pool and the staff treated us with unmatched warmth and courtesy."
                </p>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&q=80" alt="Elena Rostova" class="w-11 h-11 rounded-full object-cover border-2 border-gold-400">
                <div>
                    <h4 class="font-bold text-xs text-charcoal-900">Elena Rostova</h4>
                    <p class="text-[11px] text-gray-400">Geneva, Switzerland</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. CTA SECTION ("Ready for your next stay?") -->
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-charcoal-950 text-white p-8 sm:p-16 text-center">
        <div class="absolute inset-0 z-0 opacity-30">
            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1600&q=80" alt="Resort Pool Sunset" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-charcoal-950 via-charcoal-950/80 to-charcoal-950 z-0"></div>

        <div class="relative z-10 max-w-3xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Exclusive Getaway</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold mt-2 mb-4">
                Ready for your next stay?
            </h2>
            <p class="text-sm sm:text-base text-gray-300 font-light leading-relaxed mb-8">
                Book your room today and enjoy a comfortable stay with complimentary breakfast, high-speed Wi-Fi, and late checkout.
            </p>
            <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-10 py-4 rounded-full gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-gold-500/30 hover:scale-105 transition-all">
                <span>Book Now</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection
