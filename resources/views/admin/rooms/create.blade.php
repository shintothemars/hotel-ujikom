@extends('layouts.admin')

@section('title', 'Add New Room | Grand Luxe Admin')
@section('page-title', 'Create Accommodation')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Add New Room</h2>
            <p class="text-xs text-slate-400">Fill in the specifications and amenities for the new suite</p>
        </div>
        <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700">
            &larr; Back to Rooms
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-slate-950/60 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-xl">
        <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Basic Info -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Room Number *</label>
                    <input type="text" name="room_number" value="{{ old('room_number') }}" required placeholder="e.g. 401" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Room Type *</label>
                    <select name="room_type" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                        @foreach($roomTypes as $type)
                            <option value="{{ $type }}" {{ old('room_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Room Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Ocean Penthouse" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
            </div>

            <!-- 2. Pricing & Specs -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Price / Night (IDR) *</label>
                    <input type="number" name="price" value="{{ old('price', 500000) }}" required min="0" step="1000" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Capacity (Guests) *</label>
                    <input type="number" name="capacity" value="{{ old('capacity', 2) }}" required min="1" max="10" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Bed Type *</label>
                    <input type="text" name="bed_type" value="{{ old('bed_type', 'King Bed') }}" required placeholder="e.g. King Bed" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Room Size (m²) *</label>
                    <input type="number" name="size" value="{{ old('size', 35) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                </div>
            </div>

            <!-- 3. Description -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Room Description *</label>
                <textarea name="description" rows="4" required placeholder="Write a compelling luxury description of the room..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">{{ old('description') }}</textarea>
            </div>

            <!-- 4. Facilities (Checkboxes) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">Room Facilities</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-900/90 border border-slate-800">
                    @foreach($defaultFacilities as $facility)
                        <label class="flex items-center gap-2.5 text-xs text-slate-300 cursor-pointer hover:text-white">
                            <input type="checkbox" name="facilities[]" value="{{ $facility }}" {{ is_array(old('facilities')) && in_array($facility, old('facilities')) ? 'checked' : '' }} class="w-4 h-4 text-gold-500 bg-slate-800 border-slate-700 rounded focus:ring-gold-500">
                            <span>{{ $facility }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 5. Image (URL or Upload) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/photo-..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-1 focus:ring-gold-500">
                    <span class="text-[10px] text-slate-500 mt-1 block">Paste an Unsplash or external image URL</span>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Or Upload Image File</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full px-4 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-slate-300 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gold-500 file:text-white hover:file:bg-gold-600">
                    <span class="text-[10px] text-slate-500 mt-1 block">Formats: JPG, PNG, WEBP (Max: 5MB)</span>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-4">
                <a href="{{ route('admin.rooms.index') }}" class="px-6 py-3 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl gold-gradient text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-gold-500/20 hover:scale-105 transition-all">
                    Save Room
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
