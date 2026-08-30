@extends('layouts.app')

@section('title', 'My Reservations | Grand Luxe Hotel & Resort')

@section('content')
<!-- Header Banner -->
<div class="bg-charcoal-950 text-white py-14 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Guest Portal</span>
            <h1 class="font-serif text-3xl font-bold mt-1">My Reservations</h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">Manage and review your upcoming stays and past bookings</p>
        </div>
        <a href="{{ route('rooms.index') }}" class="px-6 py-3 rounded-full gold-gradient text-white text-xs font-bold uppercase tracking-wider shadow-lg hover:scale-105 transition-all">
            + Book Another Room
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    @if($reservations->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gold-200/60 p-8 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-gold-50 text-gold-600 flex items-center justify-center mx-auto text-2xl mb-4">
                🎫
            </div>
            <h3 class="font-serif text-2xl font-bold text-charcoal-900 mb-2">No Active Reservations</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">
                You haven't made any room reservations yet. Explore our luxury suites and plan your next memorable escape.
            </p>
            <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full gold-gradient text-white text-xs font-bold uppercase tracking-wider shadow-md hover:scale-105 transition-all">
                Browse Rooms & Suites
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($reservations as $reservation)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gold-200/60 shadow-md hover:shadow-lg transition-all flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    
                    <!-- Left: Room Info & Image -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 min-w-0">
                        <img src="{{ $reservation->room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=400&q=80' }}" alt="{{ $reservation->room->name ?? 'Room' }}" class="w-full sm:w-36 h-28 rounded-2xl object-cover border border-gold-100 shrink-0">
                        
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-mono text-xs font-bold text-gold-800 bg-gold-50 px-2.5 py-0.5 rounded-md border border-gold-200">
                                    {{ $reservation->booking_code }}
                                </span>
                                
                                @if($reservation->status === 'confirmed')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">Confirmed</span>
                                @elseif($reservation->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800">Pending</span>
                                @elseif($reservation->status === 'completed')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800">Completed</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600">Cancelled</span>
                                @endif
                            </div>

                            <h3 class="font-serif text-xl font-bold text-charcoal-900 truncate">
                                {{ $reservation->room->name ?? 'Suite' }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 mt-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $reservation->check_in->format('d M Y') }} &rarr; {{ $reservation->check_out->format('d M Y') }} ({{ $reservation->total_nights }}N)
                                </span>
                                <span>&bull;</span>
                                <span>{{ $reservation->adults }} Adult(s)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Price & Actions -->
                    <div class="w-full lg:w-auto flex flex-row lg:flex-col items-center lg:items-end justify-between lg:justify-center gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                        <div class="text-left lg:text-right">
                            <span class="text-[11px] text-gray-400 block">Total Amount</span>
                            <span class="font-serif text-xl font-bold text-charcoal-900">{{ $reservation->formatted_total_price }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('booking.success', $reservation->booking_code) }}" class="px-4 py-2 text-xs font-bold rounded-xl gold-gradient text-white shadow hover:scale-105 transition-all">
                                View Ticket / Voucher
                            </a>

                            @if(in_array($reservation->status, ['pending', 'confirmed']))
                                <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 text-xs font-bold rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="pt-6">
                {{ $reservations->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
