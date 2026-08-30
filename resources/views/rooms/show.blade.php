@extends('layouts.app')

@section('title', $room->name . ' | Grand Luxe Hotel & Resort')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-cream border-b border-gold-200/50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-gold-600">Home</a>
        <span>/</span>
        <a href="{{ route('rooms.index') }}" class="hover:text-gold-600">Rooms & Suites</a>
        <span>/</span>
        <span class="font-semibold text-charcoal-900 truncate">{{ $room->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- LEFT: Photo Gallery & Details (2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Main Photo Gallery -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $room->name }}" class="w-full h-[420px] sm:h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                <div class="absolute top-4 left-4 flex items-center gap-2">
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-charcoal-900 uppercase tracking-wider shadow-sm">
                        {{ $room->room_type }}
                    </span>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-charcoal-900/80 backdrop-blur-md text-gold-300">
                        Room #{{ $room->room_number }}
                    </span>
                </div>

                <div class="absolute bottom-4 left-4 text-white">
                    <div class="text-gold-400 text-sm mb-1">★★★★★ 5.0 (Exceptional Stay)</div>
                    <h1 class="font-serif text-3xl sm:text-4xl font-bold">{{ $room->name }}</h1>
                </div>
            </div>

            <!-- Specs Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-6 rounded-3xl bg-white border border-gold-200/60 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gold-50 text-gold-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-400 block">Capacity</span>
                        <span class="text-sm font-bold text-charcoal-900">{{ $room->capacity }} Guests</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gold-50 text-gold-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-400 block">Bed Type</span>
                        <span class="text-sm font-bold text-charcoal-900">{{ $room->bed_type }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gold-50 text-gold-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-400 block">Room Size</span>
                        <span class="text-sm font-bold text-charcoal-900">{{ $room->size }} m²</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gold-50 text-gold-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-400 block">Status</span>
                        <span class="text-sm font-bold text-emerald-600 uppercase">{{ $room->status }}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-3xl p-8 border border-gold-200/60 shadow-md">
                <h3 class="font-serif text-2xl font-bold text-charcoal-900 mb-4">Suite Description</h3>
                <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                    {{ $room->description }}
                </p>
            </div>

            <!-- Room Facilities -->
            <div class="bg-white rounded-3xl p-8 border border-gold-200/60 shadow-md">
                <h3 class="font-serif text-2xl font-bold text-charcoal-900 mb-6">Suite Facilities & Amenities</h3>
                
                @if(!empty($room->facilities) && is_array($room->facilities))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($room->facilities as $facility)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-cream border border-gold-100/80 text-sm font-medium text-charcoal-900">
                                <div class="w-6 h-6 rounded-full gold-gradient text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    ✓
                                </div>
                                <span>{{ $facility }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Standard luxury facilities provided.</p>
                @endif
            </div>

            <!-- Hotel Policies -->
            <div class="bg-white rounded-3xl p-8 border border-gold-200/60 shadow-md">
                <h3 class="font-serif text-xl font-bold text-charcoal-900 mb-4">Stay Information & Policies</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-gray-600">
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-gold-700">• Check-in:</span>
                        <span>From 14:00 PM</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-gold-700">• Check-out:</span>
                        <span>Until 12:00 PM</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-gold-700">• Cancellation:</span>
                        <span>Free cancellation up to 24h before check-in.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="font-bold text-gold-700">• Breakfast:</span>
                        <span>Complimentary daily artisanal buffet included.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Interactive Booking Sidebar Calculator (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border-2 border-gold-200 sticky top-28" x-data="{
                checkIn: '{{ $checkIn }}',
                checkOut: '{{ $checkOut }}',
                adults: {{ $adults }},
                children: {{ $children }},
                isChecking: false,
                isAvailable: {{ json_encode($isAvailable) }},
                statusMessage: '{{ $isAvailable ? '✓ Room Available' : ($isAvailable === false ? '✕ Room Unavailable for Selected Dates' : '') }}',
                totalNights: {{ $totalNights }},
                totalPrice: '{{ number_format($totalPrice, 0, ',', '.') }}',
                
                checkAvailability() {
                    if (!this.checkIn || !this.checkOut) return;
                    this.isChecking = true;
                    
                    fetch('{{ route('rooms.check-availability', $room->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            check_in: this.checkIn,
                            check_out: this.checkOut
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isChecking = false;
                        this.isAvailable = data.available;
                        this.statusMessage = data.available ? '✓ Room Available' : '✕ Room Unavailable';
                        this.totalNights = data.total_nights;
                        this.totalPrice = Number(data.total_price).toLocaleString('id-ID');
                    })
                    .catch(err => {
                        this.isChecking = false;
                        console.error(err);
                    });
                }
            }">
                
                <!-- Price Box -->
                <div class="pb-6 border-b border-gray-100 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs text-gray-400 block">Rate per night</span>
                        <span class="font-serif text-3xl font-bold text-charcoal-900">{{ $room->formatted_price }}</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gold-100 text-gold-800">Best Price</span>
                </div>

                <!-- Form Inputs -->
                <form method="GET" action="{{ route('booking.create') }}" class="space-y-4 pt-6">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Check-in</label>
                            <input type="date" name="check_in" x-model="checkIn" @change="checkAvailability()" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Check-out</label>
                            <input type="date" name="check_out" x-model="checkOut" @change="checkAvailability()" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Adults</label>
                            <select name="adults" x-model="adults" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                                <option value="1">1 Adult</option>
                                <option value="2">2 Adults</option>
                                <option value="3">3 Adults</option>
                                <option value="4">4 Adults</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Children</label>
                            <select name="children" x-model="children" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                                <option value="0">0 Children</option>
                                <option value="1">1 Child</option>
                                <option value="2">2 Children</option>
                            </select>
                        </div>
                    </div>

                    <!-- Availability Status Alert -->
                    <div class="pt-2">
                        <button type="button" @click="checkAvailability()" class="w-full py-2 text-xs font-bold uppercase tracking-wider text-gold-700 bg-gold-50 hover:bg-gold-100 rounded-xl transition-colors">
                            <span x-show="!isChecking">Check Availability</span>
                            <span x-show="isChecking">Checking...</span>
                        </button>

                        <template x-if="isAvailable === true">
                            <div class="mt-3 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold text-center flex items-center justify-center gap-1.5">
                                <span>✓</span> Room Available for Selected Dates
                            </div>
                        </template>

                        <template x-if="isAvailable === false">
                            <div class="mt-3 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold text-center flex items-center justify-center gap-1.5">
                                <span>✕</span> Room is Already Booked for These Dates
                            </div>
                        </template>
                    </div>

                    <!-- Live Price Breakdown -->
                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between text-gray-500">
                            <span>Room rate</span>
                            <span>{{ $room->formatted_price }} &times; <span x-text="totalNights"></span> night(s)</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Taxes & Resort Fee</span>
                            <span class="text-emerald-600 font-semibold">Included</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-charcoal-900 pt-2 border-t border-dashed border-gray-200">
                            <span>Total Price</span>
                            <span class="font-serif text-lg font-bold text-gold-700">Rp <span x-text="totalPrice"></span></span>
                        </div>
                    </div>

                    <!-- Book Button -->
                    <button type="submit" :disabled="isAvailable === false" :class="isAvailable === false ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'gold-gradient shadow-xl shadow-gold-500/30 hover:scale-[1.02]'" class="w-full py-4 rounded-xl text-white font-bold text-sm uppercase tracking-wider transition-all">
                        Book This Room
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-[11px] text-gray-400 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Instant Confirmation & Secure Reservation
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Accommodations -->
    @if($similarRooms->isNotEmpty())
        <div class="mt-20 pt-12 border-t border-gold-200/60">
            <h3 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal-900 mb-8">Other Luxury Accommodations</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($similarRooms as $sim)
                    <div class="bg-white rounded-3xl overflow-hidden border border-gold-200/60 shadow-lg hover:shadow-xl transition-all group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $sim->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $sim->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 uppercase">{{ $sim->room_type }}</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-serif text-lg font-bold text-charcoal-900">{{ $sim->name }}</h4>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                <span class="font-serif font-bold text-gold-700">{{ $sim->formatted_price }}</span>
                                <a href="{{ route('rooms.show', $sim->id) }}" class="text-xs font-bold text-charcoal-900 hover:text-gold-700">View &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
