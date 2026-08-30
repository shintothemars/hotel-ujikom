@extends('layouts.app')

@section('title', 'Rooms & Suites | Grand Luxe Hotel & Resort')

@section('content')
<!-- Header Banner -->
<div class="bg-charcoal-950 text-white py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-25">
        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1600&q=80" alt="Suites Header" class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Accommodations</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold mt-2 mb-3">Find Your Perfect Room</h1>
        <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto font-light">
            Comfortable rooms for every kind of stay. Choose your desired sanctuary.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Filter Card -->
    <div class="bg-white rounded-3xl p-6 shadow-xl border border-gold-200/60 mb-12">
        <form method="GET" action="{{ route('rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
            
            <!-- Check In -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Check-in</label>
                <input type="date" name="check_in" value="{{ request('check_in', $checkIn) }}" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
            </div>

            <!-- Check Out -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Check-out</label>
                <input type="date" name="check_out" value="{{ request('check_out', $checkOut) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
            </div>

            <!-- Room Type Filter -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Room Type</label>
                <select name="room_type" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                    <option value="All">All Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type }}" {{ request('room_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Guests Filter -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Guests</label>
                <select name="adults" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                    <option value="1" {{ request('adults', $adults) == 1 ? 'selected' : '' }}>1 Adult</option>
                    <option value="2" {{ request('adults', $adults) == 2 ? 'selected' : '' }}>2 Adults</option>
                    <option value="3" {{ request('adults', $adults) == 3 ? 'selected' : '' }}>3 Adults</option>
                    <option value="4" {{ request('adults', $adults) == 4 ? 'selected' : '' }}>4+ Adults</option>
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Sort By</label>
                <select name="sort" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="capacity_desc" {{ request('sort') === 'capacity_desc' ? 'selected' : '' }}>Capacity</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl gold-gradient text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Search
                </button>
                @if(request()->hasAny(['room_type', 'check_in', 'check_out', 'adults', 'sort']))
                    <a href="{{ route('rooms.index') }}" title="Reset Filters" class="p-2.5 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Active Filters Feedback -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm font-semibold text-charcoal-900">
            Showing <span class="text-gold-700 font-bold">{{ $rooms->total() }}</span> available accommodations
        </p>
    </div>

    <!-- Rooms Catalog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($rooms as $room)
            <div class="bg-white rounded-3xl overflow-hidden border border-gold-200/60 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col group hover:-translate-y-1.5">
                
                <!-- Room Image -->
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-charcoal-900 uppercase tracking-wider shadow-sm">
                            {{ $room->room_type }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-charcoal-900/80 backdrop-blur-md text-gold-300">
                            #{{ $room->room_number }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-4 text-gold-400 text-xs flex items-center gap-1 font-bold">
                        <span>★★★★★</span>
                        <span class="text-white text-[11px] font-normal ml-1">5.0</span>
                    </div>
                </div>

                <!-- Room Info -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-serif text-2xl font-bold text-charcoal-900 group-hover:text-gold-700 transition-colors">
                            {{ $room->name }}
                        </h3>

                        <!-- Specs Bar -->
                        <div class="flex items-center gap-3 text-xs text-gray-500 mt-2.5 mb-4 py-2 border-y border-gray-100">
                            <span class="flex items-center gap-1 font-medium">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $room->capacity }} Guests
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1 font-medium">
                                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                {{ $room->bed_type }}
                            </span>
                            <span>•</span>
                            <span class="font-medium">{{ $room->size }} m²</span>
                        </div>

                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                            {{ $room->description }}
                        </p>

                        <!-- Facilities Pills -->
                        @if(!empty($room->facilities) && is_array($room->facilities))
                            <div class="flex flex-wrap gap-1.5 mb-6">
                                @foreach(array_slice($room->facilities, 0, 3) as $fac)
                                    <span class="px-2 py-0.5 rounded-md bg-gold-50 text-[10px] font-semibold text-gold-800 border border-gold-200/60">
                                        {{ $fac }}
                                    </span>
                                @endforeach
                                @if(count($room->facilities) > 3)
                                    <span class="px-2 py-0.5 rounded-md bg-gray-50 text-[10px] font-semibold text-gray-500">
                                        +{{ count($room->facilities) - 3 }} more
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-[11px] text-gray-400 block">Price per night</span>
                            <span class="font-serif text-xl font-bold text-charcoal-900">{{ $room->formatted_price }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('rooms.show', ['id' => $room->id, 'check_in' => request('check_in', $checkIn), 'check_out' => request('check_out', $checkOut), 'adults' => request('adults', $adults)]) }}" class="py-2.5 px-4 text-xs font-bold rounded-xl border border-gold-300 text-gold-800 hover:bg-gold-50 transition-colors">
                                View Detail
                            </a>
                            <a href="{{ route('booking.create', ['room_id' => $room->id, 'check_in' => request('check_in', $checkIn), 'check_out' => request('check_out', $checkOut), 'adults' => request('adults', $adults)]) }}" class="py-2.5 px-4 text-xs font-bold rounded-xl gold-gradient text-white shadow-md hover:shadow-lg hover:scale-105 transition-all">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-gold-100 p-8">
                <div class="w-16 h-16 rounded-full bg-gold-100 text-gold-600 flex items-center justify-center mx-auto text-2xl mb-4">
                    🔍
                </div>
                <h3 class="font-serif text-2xl font-bold text-charcoal-900 mb-2">No Rooms Found</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">
                    No accommodations matched your search criteria or desired dates. Try adjusting your dates or resetting the filter.
                </p>
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full gold-gradient text-white text-xs font-bold uppercase tracking-wider shadow">
                    Reset All Filters
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
