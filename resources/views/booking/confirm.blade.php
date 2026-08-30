@extends('layouts.app')

@section('title', 'Confirm Your Reservation | Grand Luxe Hotel & Resort')

@section('content')
<div class="bg-cream py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Stepper -->
        <div class="mb-10 text-center">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">Reservation Step 2 of 2</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal-900 mt-1">Confirm Your Reservation</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">Please review your booking details before final confirmation</p>

            <div class="flex items-center justify-center gap-3 mt-6 max-w-xs mx-auto">
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-600">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">✓</span>
                    <span>Details</span>
                </div>
                <div class="w-12 h-0.5 bg-gold-400"></div>
                <div class="flex items-center gap-2 text-xs font-bold text-gold-700">
                    <span class="w-6 h-6 rounded-full gold-gradient text-white flex items-center justify-center text-xs">2</span>
                    <span>Review & Confirm</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('booking.store') }}" class="space-y-8">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="check_in" value="{{ $bookingData['check_in'] }}">
            <input type="hidden" name="check_out" value="{{ $bookingData['check_out'] }}">
            <input type="hidden" name="adults" value="{{ $bookingData['adults'] }}">
            <input type="hidden" name="children" value="{{ $bookingData['children'] ?? 0 }}">
            <input type="hidden" name="guest_name" value="{{ $bookingData['guest_name'] }}">
            <input type="hidden" name="guest_email" value="{{ $bookingData['guest_email'] }}">
            <input type="hidden" name="guest_phone" value="{{ $bookingData['guest_phone'] }}">
            <input type="hidden" name="special_request" value="{{ $bookingData['special_request'] ?? '' }}">

            <!-- Review Card -->
            <div class="bg-white rounded-3xl p-8 border border-gold-200/80 shadow-xl space-y-8">
                
                <!-- 1. ROOM DETAILS -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gold-700 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gold-500"></span>
                        Selected Accommodation
                    </h3>

                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $room->name }}" class="w-full sm:w-44 h-32 rounded-2xl object-cover border border-gold-100">
                        <div class="flex-1 text-center sm:text-left">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gold-100 text-gold-800 uppercase">{{ $room->room_type }}</span>
                            <h4 class="font-serif text-2xl font-bold text-charcoal-900 mt-1">{{ $room->name }}</h4>
                            <p class="text-xs text-gray-500 mt-1">Room #{{ $room->room_number }} &bull; {{ $room->bed_type }} &bull; {{ $room->size }} m²</p>
                            <p class="text-sm font-bold text-gold-700 mt-2">{{ $room->formatted_price }} / night</p>
                        </div>
                    </div>
                </div>

                <!-- 2. STAY & GUEST INFORMATION -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-gray-100">
                    
                    <!-- Stay Details -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-charcoal-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Stay Schedule
                        </h4>
                        
                        <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Check-in Date:</span>
                                <span class="font-bold text-charcoal-900">{{ date('d F Y', strtotime($bookingData['check_in'])) }} (14:00)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Check-out Date:</span>
                                <span class="font-bold text-charcoal-900">{{ date('d F Y', strtotime($bookingData['check_out'])) }} (12:00)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Duration:</span>
                                <span class="font-bold text-gold-700">{{ $totalNights }} Night(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Guests:</span>
                                <span class="font-bold text-charcoal-900">{{ $bookingData['adults'] }} Adult(s), {{ $bookingData['children'] ?? 0 }} Child(ren)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Details -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-charcoal-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Guest Contact
                        </h4>

                        <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Full Name:</span>
                                <span class="font-bold text-charcoal-900">{{ $bookingData['guest_name'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Email:</span>
                                <span class="font-bold text-charcoal-900">{{ $bookingData['guest_email'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Phone:</span>
                                <span class="font-bold text-charcoal-900">{{ $bookingData['guest_phone'] }}</span>
                            </div>
                            @if(!empty($bookingData['special_request']))
                                <div class="pt-2 border-t border-gold-200/50">
                                    <span class="text-gray-500 block">Special Request:</span>
                                    <span class="text-charcoal-900 italic font-medium mt-0.5 block">{{ $bookingData['special_request'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 3. PRICE CALCULATION SUMMARY -->
                <div class="p-6 rounded-2xl bg-charcoal-950 text-white space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gold-400">Official Price Breakdown</h4>
                    
                    <div class="flex justify-between text-xs text-gray-300">
                        <span>Room Rate ({{ $room->formatted_price }} &times; {{ $totalNights }} nights)</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-300">
                        <span>Government Tax & Service Charge (10%)</span>
                        <span class="text-emerald-400 font-semibold">Included</span>
                    </div>

                    <div class="pt-3 border-t border-charcoal-800 flex justify-between items-baseline">
                        <span class="text-sm font-bold">Total Reservation Amount</span>
                        <span class="font-serif text-2xl font-bold text-gold-400">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('booking.create', ['room_id' => $room->id, 'check_in' => $bookingData['check_in'], 'check_out' => $bookingData['check_out'], 'adults' => $bookingData['adults'], 'children' => $bookingData['children'] ?? 0]) }}" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-gray-300 text-charcoal-800 hover:bg-gray-100 text-xs font-bold uppercase tracking-wider text-center transition-colors">
                    &larr; Back to Edit
                </a>

                <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-xl gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-gold-500/30 hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Confirm Booking
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
