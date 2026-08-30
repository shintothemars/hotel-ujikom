@extends('layouts.app')

@section('title', 'Booking Voucher - #' . $reservation->booking_code . ' | Grand Luxe Hotel')

@section('content')
<div class="bg-cream py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Banner -->
        <div class="text-center mb-8 no-print">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl font-bold mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                ✓
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal-900">Booking Confirmed!</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                Your reservation has been successfully created and secured in our system. An official voucher has been generated below.
            </p>
        </div>

        <!-- Luxury Boarding Ticket / Voucher Card -->
        <div class="bg-white rounded-3xl overflow-hidden border-2 border-gold-300 shadow-2xl relative">
            
            <!-- Ticket Header Bar -->
            <div class="bg-charcoal-950 text-white p-6 sm:p-8 flex items-center justify-between border-b-4 border-gold-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full gold-gradient flex items-center justify-center text-white font-serif font-bold text-xl">
                        L
                    </div>
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold tracking-wider">GRAND LUXE</h2>
                        <span class="text-[9px] tracking-[0.25em] text-gold-400 font-bold uppercase block">Official Stay Voucher</span>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-widest">Booking Code</span>
                    <span class="font-mono text-sm sm:text-lg font-bold text-gold-400">{{ $reservation->booking_code }}</span>
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="p-6 sm:p-8 space-y-6">
                
                <!-- Status & Booking Date -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <span class="text-xs text-gray-400 block">Reservation Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mt-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            {{ $reservation->status }}
                        </span>
                    </div>

                    <div class="text-right">
                        <span class="text-xs text-gray-400 block">Issued On</span>
                        <span class="text-xs font-bold text-charcoal-900 mt-1 block">{{ $reservation->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <!-- Guest & Room Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gold-700 block">Guest Information</span>
                        <p class="font-bold text-sm text-charcoal-900">{{ $reservation->guest_name }}</p>
                        <p class="text-xs text-gray-500">{{ $reservation->guest_email }}</p>
                        <p class="text-xs text-gray-500">{{ $reservation->guest_phone }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gold-700 block">Accommodation</span>
                        <p class="font-bold text-sm text-charcoal-900">{{ $reservation->room->name ?? 'Luxury Room' }}</p>
                        <p class="text-xs text-gray-500">Room Number: <span class="font-bold text-charcoal-900">#{{ $reservation->room->room_number ?? '101' }}</span></p>
                        <p class="text-xs text-gray-500">Category: <span class="font-semibold text-gold-800">{{ $reservation->room->room_type ?? 'Deluxe' }}</span></p>
                    </div>
                </div>

                <!-- Stay Dates Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-gold-50/60 border border-gold-200/60 text-center">
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold block">Check-in</span>
                        <span class="text-xs sm:text-sm font-bold text-charcoal-900">{{ $reservation->check_in->format('d M Y') }}</span>
                        <span class="text-[10px] text-gray-500 block">14:00 PM</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold block">Check-out</span>
                        <span class="text-xs sm:text-sm font-bold text-charcoal-900">{{ $reservation->check_out->format('d M Y') }}</span>
                        <span class="text-[10px] text-gray-500 block">12:00 PM</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold block">Duration</span>
                        <span class="text-xs sm:text-sm font-bold text-gold-700">{{ $reservation->total_nights }} Night(s)</span>
                        <span class="text-[10px] text-gray-500 block">Stay</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold block">Guests</span>
                        <span class="text-xs sm:text-sm font-bold text-charcoal-900">{{ $reservation->adults }} Adult(s)</span>
                        @if($reservation->children > 0)
                            <span class="text-[10px] text-gray-500 block">{{ $reservation->children }} Child(ren)</span>
                        @endif
                    </div>
                </div>

                @if($reservation->special_request)
                    <div class="p-3 rounded-xl bg-gray-50 text-xs text-gray-600">
                        <span class="font-bold text-charcoal-900">Special Request:</span> {{ $reservation->special_request }}
                    </div>
                @endif

                <!-- Total Amount & Barcode Simulation -->
                <div class="pt-4 border-t-2 border-dashed border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-[11px] uppercase font-bold text-gray-400 block">Total Paid / Due</span>
                        <span class="font-serif text-2xl sm:text-3xl font-bold text-gold-700">{{ $reservation->formatted_total_price }}</span>
                    </div>

                    <!-- Visual Luxury Barcode -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-0.5 h-10 px-3 py-1 bg-white border border-gray-300 rounded">
                            <span class="w-1 h-8 bg-black"></span>
                            <span class="w-0.5 h-8 bg-black"></span>
                            <span class="w-1.5 h-8 bg-black"></span>
                            <span class="w-0.5 h-8 bg-black"></span>
                            <span class="w-2 h-8 bg-black"></span>
                            <span class="w-0.5 h-8 bg-black"></span>
                            <span class="w-1 h-8 bg-black"></span>
                            <span class="w-2 h-8 bg-black"></span>
                            <span class="w-0.5 h-8 bg-black"></span>
                            <span class="w-1.5 h-8 bg-black"></span>
                            <span class="w-0.5 h-8 bg-black"></span>
                            <span class="w-1 h-8 bg-black"></span>
                        </div>
                        <span class="font-mono text-[9px] text-gray-400 mt-1">{{ $reservation->booking_code }}</span>
                    </div>
                </div>

                <!-- Check-in Instruction -->
                <div class="text-[11px] text-gray-400 text-center pt-2">
                    Please present this voucher along with valid government photo identification upon arrival at the front desk.
                </div>
            </div>
        </div>

        <!-- Action Buttons (Hidden when printing) -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4 no-print">
            <button onclick="window.print()" class="px-6 py-3.5 rounded-xl bg-charcoal-900 text-white font-bold text-xs uppercase tracking-wider hover:bg-charcoal-800 transition-all flex items-center gap-2 shadow-lg">
                <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Ticket
            </button>

            <a href="{{ route('my.reservations') }}" class="px-6 py-3.5 rounded-xl border border-gold-300 text-gold-800 font-bold text-xs uppercase tracking-wider hover:bg-gold-50 transition-all">
                My Reservations
            </a>

            <a href="{{ route('home') }}" class="px-6 py-3.5 rounded-xl bg-white border border-gray-200 text-charcoal-800 font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-all">
                Back to Home
            </a>
        </div>

    </div>
</div>
@endsection
