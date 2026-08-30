@extends('layouts.admin')

@section('title', 'Manage Rooms | Grand Luxe Admin')
@section('page-title', 'Manage Accommodations')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Room Inventory</h2>
            <p class="text-xs text-slate-400">Total of {{ $rooms->total() }} rooms currently registered</p>
        </div>

        <a href="{{ route('admin.rooms.create') }}" class="px-5 py-2.5 rounded-xl gold-gradient text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-gold-500/20 hover:scale-105 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Add Room
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by room #, name, or type..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white placeholder-slate-500 focus:ring-1 focus:ring-gold-500 focus:border-gold-500">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-gold-500">
                    <option value="all">All Statuses</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'room_type']))
                    <a href="{{ route('admin.rooms.index') }}" class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white" title="Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Rooms Table -->
    <div class="bg-slate-950/60 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">Room Number</th>
                        <th class="py-4 px-6">Room Info</th>
                        <th class="py-4 px-6">Type</th>
                        <th class="py-4 px-6">Price / Night</th>
                        <th class="py-4 px-6">Capacity</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-gold-400 text-sm">
                                #{{ $room->room_number }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=200&q=80' }}" alt="{{ $room->name }}" class="w-12 h-10 rounded-lg object-cover border border-slate-700">
                                    <div>
                                        <p class="font-bold text-white text-sm">{{ $room->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $room->bed_type }} &bull; {{ $room->size }} m²</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $room->room_type }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-serif font-bold text-slate-200 text-sm">
                                {{ $room->formatted_price }}
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-medium">
                                {{ $room->capacity }} Guests
                            </td>
                            <td class="py-4 px-6">
                                @if($room->status === 'available')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-950 text-emerald-300 border border-emerald-800">
                                        Available
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-rose-950 text-rose-300 border border-rose-800">
                                        Unavailable
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.rooms.show', $room->id) }}" class="p-1.5 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="p-1.5 rounded-lg bg-slate-800 text-gold-400 hover:bg-gold-500 hover:text-white" title="Edit Room">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.rooms.destroy', $room->id) }}" onsubmit="return confirm('Are you sure you want to delete Room #{{ $room->room_number }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-slate-800 text-red-400 hover:bg-red-500 hover:text-white" title="Delete Room">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">No rooms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $rooms->links() }}
        </div>
    </div>

</div>
@endsection
