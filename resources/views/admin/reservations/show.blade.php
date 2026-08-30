@extends('layouts.admin')

@section('title', 'Reservation #' . $reservation->booking_code . ' | Grand Luxe Admin')
@section('page-title', 'Reservation Voucher & Invoice')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between no-print">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Reservation Details</h2>
            <p class="text-xs text-slate-400">Booking reference: <span class="font-mono text-gold-400 font-bold">#{{ $reservation->booking_code }}</span></p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-200 text-xs font-bold hover:bg-slate-700 flex items-center gap-2">
                <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Voucher
            </button>
            <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700">
                &larr; Back
            </a>
        </div>
    </div>

    <!-- Voucher & Invoice Card -->
    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-gold-200 text-charcoal-900">
        
        <!-- Header -->
        <div class="bg-charcoal-950 text-white p-8 flex items-center justify-between border-b-4 border-gold-500">
            <div>
                <span class="font-serif text-2xl font-bold tracking-wider">GRAND LUXE</span>
                <span class="text-[10px] tracking-[0.25em] text-gold-400 font-bold uppercase block">Official Stay Voucher</span>
            </div>
            <div class="text-right">
                <span class="text-xs text-gray-400 block font-bold uppercase">Booking Reference</span>
                <span class="font-mono text-lg font-bold text-gold-400">{{ $reservation->booking_code }}</span>
            </div>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Quick Status Change Bar -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 rounded-2xl bg-cream border border-gold-200 no-print">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold uppercase text-charcoal-900">Current Status:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-900 text-gold-400">
                        {{ $reservation->status }}
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.reservations.status', $reservation->id) }}" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <span class="text-xs text-gray-500">Change Status:</span>
                    <select name="status" class="px-3 py-1.5 rounded-xl border border-gray-300 text-xs font-semibold bg-white text-charcoal-900">
                        <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $reservation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-3 py-1.5 rounded-xl gold-gradient text-white text-xs font-bold">
                        Update
                    </button>
                </form>
            </div>

            <!-- Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2">
                    <span class="text-[10px] font-bold uppercase text-gold-700 block">Guest Details</span>
                    <p class="font-bold text-sm">{{ $reservation->guest_name }}</p>
                    <p class="text-xs text-gray-500">{{ $reservation->guest_email }}</p>
                    <p class="text-xs text-gray-500">{{ $reservation->guest_phone }}</p>
                </div>

                <div class="p-4 rounded-2xl bg-cream border border-gold-100 space-y-2">
                    <span class="text-[10px] font-bold uppercase text-gold-700 block">Room Information</span>
                    <p class="font-bold text-sm">{{ $reservation->room->name ?? 'Room #' . $reservation->room_id }}</p>
                    <p class="text-xs text-gray-500">Room Number: <span class="font-bold text-charcoal-900">#{{ $reservation->room->room_number ?? '101' }}</span></p>
                    <p class="text-xs text-gray-500">Category: <span class="font-semibold text-gold-800">{{ $reservation->room->room_type ?? 'Deluxe' }}</span></p>
                </div>
            </div>

            <!-- Schedule -->
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
                    <span class="text-[10px] text-gray-400 uppercase font-bold block">Total Nights</span>
                    <span class="text-xs sm:text-sm font-bold text-gold-700">{{ $reservation->total_nights }} Night(s)</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 uppercase font-bold block">Guests</span>
                    <span class="text-xs sm:text-sm font-bold text-charcoal-900">{{ $reservation->adults }} Adults, {{ $reservation->children }} Children</span>
                </div>
            </div>

            @if($reservation->special_request)
                <div class="p-3 rounded-xl bg-gray-50 text-xs text-gray-600">
                    <span class="font-bold text-charcoal-900">Special Request:</span> {{ $reservation->special_request }}
                </div>
            @endif

            <!-- Invoice Total -->
            <div class="p-6 rounded-2xl bg-charcoal-950 text-white flex items-center justify-between">
                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold">Total Stay Amount</span>
                    <span class="text-xs text-slate-400">{{ $reservation->room->formatted_price ?? '' }} &times; {{ $reservation->total_nights }} night(s)</span>
                </div>
                <span class="font-serif text-3xl font-bold text-gold-400">{{ $reservation->formatted_total_price }}</span>
            </div>

        </div>

    </div>

</div>
@endsection
