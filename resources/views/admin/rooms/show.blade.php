@extends('layouts.admin')

@section('title', 'Room #' . $room->room_number . ' Details | Grand Luxe Admin')
@section('page-title', 'Room Specifications')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Room #{{ $room->room_number }} &mdash; {{ $room->name }}</h2>
            <p class="text-xs text-slate-400">Detailed overview and recent booking history</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="px-4 py-2 rounded-xl gold-gradient text-white text-xs font-bold shadow">
                Edit Room
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700">
                &larr; Back
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-xl relative h-72 sm:h-96">
                <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                <div class="absolute top-4 left-4 flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-900/90 text-white uppercase">{{ $room->room_type }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $room->status === 'available' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-rose-950 text-rose-300 border border-rose-800' }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-slate-950/60 border border-slate-800 space-y-4">
                <h3 class="font-serif text-xl font-bold text-white">Description</h3>
                <p class="text-xs text-slate-300 leading-relaxed whitespace-pre-line">{{ $room->description }}</p>
            </div>

            <!-- Facilities -->
            <div class="p-6 rounded-3xl bg-slate-950/60 border border-slate-800">
                <h3 class="font-serif text-xl font-bold text-white mb-4">Included Amenities</h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($room->facilities ?? [] as $facility)
                        <div class="flex items-center gap-2 text-xs text-slate-300 p-2.5 rounded-xl bg-slate-900 border border-slate-800">
                            <span class="text-gold-400">✓</span>
                            <span>{{ $facility }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Specs & History -->
        <div class="space-y-6">
            <div class="p-6 rounded-3xl bg-slate-950/60 border border-slate-800 space-y-4">
                <h3 class="font-serif text-lg font-bold text-white pb-3 border-b border-slate-800">Specifications</h3>
                
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Nightly Rate:</span>
                        <span class="font-serif font-bold text-gold-400 text-base">{{ $room->formatted_price }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Capacity:</span>
                        <span class="font-bold text-white">{{ $room->capacity }} Guests</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Bed Type:</span>
                        <span class="font-bold text-white">{{ $room->bed_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Floor Space:</span>
                        <span class="font-bold text-white">{{ $room->size }} m²</span>
                    </div>
                </div>
            </div>

            <!-- Recent Room Stays -->
            <div class="p-6 rounded-3xl bg-slate-950/60 border border-slate-800">
                <h3 class="font-serif text-lg font-bold text-white mb-3">Recent Bookings</h3>
                <div class="space-y-2.5">
                    @forelse($room->reservations as $res)
                        <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 text-xs">
                            <div class="flex justify-between font-mono font-bold text-gold-400">
                                <span>{{ $res->booking_code }}</span>
                                <span class="text-[10px] uppercase {{ $res->status === 'confirmed' ? 'text-emerald-400' : 'text-slate-400' }}">{{ $res->status }}</span>
                            </div>
                            <p class="text-slate-300 font-semibold mt-1">{{ $res->guest_name }}</p>
                            <p class="text-[10px] text-slate-500">{{ $res->check_in->format('d M') }} &rarr; {{ $res->check_out->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 py-2 text-center">No bookings for this room yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
