@extends('layouts.app')

@section('title', 'Book Your Stay | Grand Luxe Hotel & Resort')

@section('content')
<div class="bg-cream py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Progress Steps -->
        <div class="mb-10 text-center">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">Reservation Step 1 of 2</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal-900 mt-1">Book Your Stay</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">Please complete your stay details and guest information</p>

            <!-- Stepper Indicator -->
            <div class="flex items-center justify-center gap-3 mt-6 max-w-xs mx-auto">
                <div class="flex items-center gap-2 text-xs font-bold text-gold-700">
                    <span class="w-6 h-6 rounded-full gold-gradient text-white flex items-center justify-center text-xs">1</span>
                    <span>Guest Details</span>
                </div>
                <div class="w-12 h-0.5 bg-gold-200"></div>
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                    <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-xs">2</span>
                    <span>Confirmation</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('booking.confirm') }}" x-data="{
            roomPrice: {{ $room->price }},
            checkIn: '{{ old('check_in', $checkIn) }}',
            checkOut: '{{ old('check_out', $checkOut) }}',
            adults: {{ old('adults', $adults) }},
            children: {{ old('children', $children) }},
            
            get totalNights() {
                if (!this.checkIn || !this.checkOut) return 1;
                let start = new Date(this.checkIn);
                let end = new Date(this.checkOut);
                let diffTime = end - start;
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays > 0 ? diffDays : 1;
            },

            get totalPriceFormatted() {
                let total = this.roomPrice * this.totalNights;
                return Number(total).toLocaleString('id-ID');
            }
        }">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left 2 Cols: Stay & Guest Form -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- 1. SELECTED ROOM CARD -->
                    <div class="bg-white rounded-3xl p-6 border border-gold-200/60 shadow-md">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gold-700 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold-500"></span>
                            Selected Accommodation
                        </h2>

                        <div class="flex flex-col sm:flex-row gap-5 items-center sm:items-start">
                            <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $room->name }}" class="w-full sm:w-36 h-28 rounded-2xl object-cover border border-gold-100">
                            
                            <div class="flex-1 text-center sm:text-left">
                                <div class="flex items-center justify-center sm:justify-between gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gold-100 text-gold-800 uppercase">{{ $room->room_type }}</span>
                                    <span class="text-xs text-gray-500 font-medium">Room #{{ $room->room_number }}</span>
                                </div>
                                <h3 class="font-serif text-xl font-bold text-charcoal-900 mt-1">{{ $room->name }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $room->capacity }} Guests max &bull; {{ $room->bed_type }} &bull; {{ $room->size }} m²</p>
                                <p class="font-serif font-bold text-gold-700 mt-2">{{ $room->formatted_price }} <span class="text-xs text-gray-400 font-normal">/ night</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. STAY DETAILS -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gold-200/60 shadow-md space-y-4">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gold-700 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold-500"></span>
                            Stay Details
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Check-in Date *</label>
                                <input type="date" name="check_in" x-model="checkIn" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Check-out Date *</label>
                                <input type="date" name="check_out" x-model="checkOut" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Adults *</label>
                                <select name="adults" x-model="adults" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                                    @for($i = 1; $i <= $room->capacity; $i++)
                                        <option value="{{ $i }}">{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Children</label>
                                <select name="children" x-model="children" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-charcoal-900 focus:ring-2 focus:ring-gold-500 bg-white">
                                    <option value="0">0 Children</option>
                                    <option value="1">1 Child</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3 Children</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. GUEST INFORMATION -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gold-200/60 shadow-md space-y-4">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gold-700 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold-500"></span>
                            Guest Information
                        </h2>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Full Name *</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name', $user->name ?? '') }}" required placeholder="e.g. John Doe" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-gold-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Email Address *</label>
                                <input type="email" name="guest_email" value="{{ old('guest_email', $user->email ?? '') }}" required placeholder="you@example.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-gold-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Phone Number *</label>
                                <input type="tel" name="guest_phone" value="{{ old('guest_phone', '+62 ') }}" required placeholder="+62 812-xxxx-xxxx" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-gold-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-1.5">Special Requests (Optional)</label>
                            <textarea name="special_request" rows="3" placeholder="e.g. Early check-in, high floor, airport transfer..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-gold-500">{{ old('special_request') }}</textarea>
                            <span class="text-[11px] text-gray-400">Special requests are subject to availability upon arrival.</span>
                        </div>
                    </div>

                </div>

                <!-- Right 1 Col: Summary Card & Action -->
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border-2 border-gold-200 sticky top-28">
                        <h3 class="font-serif text-xl font-bold text-charcoal-900 pb-4 border-b border-gray-100">
                            Price Summary
                        </h3>

                        <div class="py-4 space-y-3 text-xs">
                            <div class="flex justify-between text-gray-500">
                                <span>Room rate</span>
                                <span class="font-semibold text-charcoal-900">{{ $room->formatted_price }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Total nights</span>
                                <span class="font-semibold text-charcoal-900"><span x-text="totalNights"></span> night(s)</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Service & Taxes (10%)</span>
                                <span class="text-emerald-600 font-semibold">Included</span>
                            </div>

                            <div class="pt-4 border-t border-dashed border-gray-200 flex justify-between items-baseline">
                                <div>
                                    <span class="text-xs text-gray-400 block">Total Due</span>
                                    <span class="font-serif text-2xl font-bold text-gold-700">Rp <span x-text="totalPriceFormatted"></span></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 py-4 rounded-xl gold-gradient text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-gold-500/25 hover:shadow-xl hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <span>Continue to Confirm</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>

                        <div class="mt-4 text-center">
                            <a href="{{ route('rooms.show', $room->id) }}" class="text-xs text-gray-400 hover:text-gray-600 font-semibold">
                                &larr; Back to Room Details
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
