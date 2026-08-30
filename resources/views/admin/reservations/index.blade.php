@extends('layouts.admin')

@section('title', 'Manage Reservations | Grand Luxe Admin')
@section('page-title', 'Reservation Management')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Guest Reservations</h2>
            <p class="text-xs text-slate-400">Total of {{ $reservations->total() }} stay bookings registered in the system</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800">
        <form method="GET" action="{{ route('admin.reservations.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by booking code, guest name, email, or phone..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white placeholder-slate-500 focus:ring-1 focus:ring-gold-500 focus:border-gold-500">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-gold-500">
                    <option value="all">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.reservations.index') }}" class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white" title="Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Reservations Table -->
    <div class="bg-slate-950/60 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">Booking Code</th>
                        <th class="py-4 px-6">Guest</th>
                        <th class="py-4 px-6">Room</th>
                        <th class="py-4 px-6">Check In</th>
                        <th class="py-4 px-6">Check Out</th>
                        <th class="py-4 px-6">Total</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions / Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-gold-400 text-sm">
                                {{ $reservation->booking_code }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-white text-sm">{{ $reservation->guest_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $reservation->guest_email }} &bull; {{ $reservation->guest_phone }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-slate-200 font-semibold">{{ $reservation->room->name ?? 'Room #' . $reservation->room_id }}</p>
                                <p class="text-[11px] text-slate-500">{{ $reservation->room->room_type ?? '' }} (#{{ $reservation->room->room_number ?? '' }})</p>
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-medium">
                                {{ $reservation->check_in->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-medium">
                                {{ $reservation->check_out->format('d M Y') }}
                                <span class="text-[10px] text-gold-400 block font-normal">({{ $reservation->total_nights }} Nights)</span>
                            </td>
                            <td class="py-4 px-6 font-serif font-bold text-slate-200 text-sm">
                                {{ $reservation->formatted_total_price }}
                            </td>
                            <td class="py-4 px-6">
                                @if($reservation->status === 'confirmed')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-950 text-emerald-300 border border-emerald-800">
                                        Confirmed
                                    </span>
                                @elseif($reservation->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-950 text-amber-300 border border-amber-800">
                                        Pending
                                    </span>
                                @elseif($reservation->status === 'completed')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-950 text-blue-300 border border-blue-800">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-800 text-slate-400">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View Voucher / Details -->
                                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="p-1.5 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 font-bold" title="View Voucher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Quick Status Change Form -->
                                    <form method="POST" action="{{ route('admin.reservations.status', $reservation->id) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="py-1 px-2 rounded-lg bg-slate-900 border border-slate-700 text-[11px] text-slate-200 focus:ring-1 focus:ring-gold-500 cursor-pointer">
                                            <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $reservation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500">No reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $reservations->links() }}
        </div>
    </div>

</div>
@endsection
