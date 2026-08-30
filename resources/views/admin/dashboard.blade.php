@extends('layouts.admin')

@section('title', 'Dashboard Overview | Grand Luxe Admin')
@section('page-title', 'Executive Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Top Welcome Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-charcoal-950 via-slate-900 to-charcoal-950 border border-slate-800 shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold-500/10 text-gold-400 border border-gold-500/20 text-xs font-semibold uppercase tracking-wider mb-2">
                👑 Hotel Management Suite
            </div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Here is a real-time summary of accommodations, guest bookings, and hotel revenue.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.rooms.create') }}" class="px-5 py-3 rounded-xl gold-gradient text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-gold-500/20 hover:scale-105 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Room
            </a>
        </div>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
        
        <!-- Total Rooms -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Total Rooms</span>
                <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center text-sm">🏨</span>
            </div>
            <p class="font-serif text-3xl font-bold text-white mt-3">{{ $totalRooms }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">In resort inventory</span>
        </div>

        <!-- Available Rooms -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Available</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">✓</span>
            </div>
            <p class="font-serif text-3xl font-bold text-emerald-400 mt-3">{{ $availableRooms }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">Ready for check-in</span>
        </div>

        <!-- Total Reservations -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Reservations</span>
                <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center text-sm">🎫</span>
            </div>
            <p class="font-serif text-3xl font-bold text-white mt-3">{{ $totalReservations }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">All-time bookings</span>
        </div>

        <!-- Pending -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Pending</span>
                <span class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm">⏳</span>
            </div>
            <p class="font-serif text-3xl font-bold text-amber-400 mt-3">{{ $pendingReservations }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">Awaiting confirmation</span>
        </div>

        <!-- Confirmed -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Confirmed</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">✨</span>
            </div>
            <p class="font-serif text-3xl font-bold text-gold-400 mt-3">{{ $confirmedReservations }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">Active stays</span>
        </div>

        <!-- Total Users -->
        <div class="p-5 rounded-2xl bg-slate-950/60 border border-slate-800 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Total Users</span>
                <span class="w-8 h-8 rounded-lg bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-sm">👥</span>
            </div>
            <p class="font-serif text-3xl font-bold text-cyan-400 mt-3">{{ $totalUsers }}</p>
            <span class="text-[11px] text-slate-500 mt-1 block">Registered guests</span>
        </div>

    </div>

    <!-- Revenue & Recent Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Recent Reservations -->
        <div class="lg:col-span-2 bg-slate-950/60 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-serif text-xl font-bold text-white">Recent Guest Reservations</h3>
                    <p class="text-xs text-slate-400">Latest incoming stay bookings</p>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="text-xs font-bold text-gold-400 hover:text-gold-300">
                    View All &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">Booking Code</th>
                            <th class="pb-3">Guest</th>
                            <th class="pb-3">Room</th>
                            <th class="pb-3">Check In / Out</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($recentReservations as $res)
                            <tr class="hover:bg-slate-900/50 transition-colors">
                                <td class="py-3.5 font-mono font-bold text-gold-400">{{ $res->booking_code }}</td>
                                <td class="py-3.5">
                                    <p class="font-bold text-slate-200">{{ $res->guest_name }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $res->guest_email }}</p>
                                </td>
                                <td class="py-3.5 text-slate-300 font-medium">{{ $res->room->name ?? 'Room #' . $res->room_id }}</td>
                                <td class="py-3.5 text-slate-400">{{ $res->check_in->format('d M') }} &rarr; {{ $res->check_out->format('d M Y') }}</td>
                                <td class="py-3.5 font-serif font-bold text-slate-200">{{ $res->formatted_total_price }}</td>
                                <td class="py-3.5">
                                    @if($res->status === 'confirmed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">Confirmed</span>
                                    @elseif($res->status === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-950 text-amber-300 border border-amber-800">Pending</span>
                                    @elseif($res->status === 'completed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-950 text-blue-300 border border-blue-800">Completed</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-slate-400">Cancelled</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('admin.reservations.show', $res->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-gold-500 hover:text-white text-slate-300 font-bold transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500">No reservations recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right 1 Col: Revenue & Popular Suites -->
        <div class="space-y-6">
            
            <!-- Revenue Card -->
            <div class="bg-gradient-to-br from-charcoal-950 to-slate-900 rounded-3xl p-6 border border-gold-500/30 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs uppercase font-bold tracking-wider text-gold-400">Gross Revenue</span>
                    <span class="text-xs text-emerald-400 font-bold">Confirmed Stays</span>
                </div>
                <h4 class="font-serif text-3xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-400 mt-2">Aggregated earnings from active & completed bookings.</p>
            </div>

            <!-- Quick Room Status Summary -->
            <div class="bg-slate-950/60 rounded-3xl p-6 border border-slate-800 shadow-xl">
                <h4 class="font-serif text-lg font-bold text-white mb-4">Popular Accommodations</h4>
                <div class="space-y-3">
                    @foreach($roomsSummary as $room)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-900/80 border border-slate-800 text-xs">
                            <div>
                                <span class="font-bold text-slate-200 block">{{ $room->name }}</span>
                                <span class="text-slate-500">#{{ $room->room_number }} &bull; {{ $room->room_type }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-gold-500/20 text-gold-400 font-bold">
                                {{ $room->reservations_count }} Bookings
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
