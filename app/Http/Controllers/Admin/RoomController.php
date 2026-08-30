<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms for admin management.
     */
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('room_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_type') && $request->room_type !== 'all') {
            $query->where('room_type', $request->room_type);
        }

        $rooms = $query->orderBy('room_number', 'asc')->paginate(10)->withQueryString();

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        $roomTypes = ['Standard', 'Deluxe', 'Executive', 'Suite'];
        $defaultFacilities = [
            'Free High-Speed Wi-Fi',
            'Air Conditioning',
            'Smart 4K TV',
            'Private Bathroom with Hot Shower',
            'Bathtub & Rain Shower',
            'Minibar & Espresso Maker',
            'In-Room Safe Deposit Box',
            'Executive Lounge Access',
            'Balcony with City/Garden View',
            '24/7 Room Service',
            'Bathrobes & Luxury Toiletries',
        ];

        return view('admin.rooms.create', compact('roomTypes', 'defaultFacilities'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', 'unique:rooms,room_number'],
            'room_type' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'bed_type' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'status' => ['required', 'in:available,unavailable'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('rooms', 'public');
            $imagePath = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        } else {
            // Default placeholder if none provided
            $imagePath = 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80';
        }

        Room::create([
            'room_number' => $validated['room_number'],
            'room_type' => $validated['room_type'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'capacity' => $validated['capacity'],
            'bed_type' => $validated['bed_type'],
            'size' => $validated['size'],
            'facilities' => $validated['facilities'] ?? [],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room #' . $validated['room_number'] . ' added successfully!');
    }

    /**
     * Display the specified room.
     */
    public function show($id)
    {
        $room = Room::with(['reservations' => function ($q) {
            $q->orderBy('created_at', 'desc')->take(10);
        }])->findOrFail($id);

        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = ['Standard', 'Deluxe', 'Executive', 'Suite'];
        $defaultFacilities = [
            'Free High-Speed Wi-Fi',
            'Air Conditioning',
            'Smart 4K TV',
            'Private Bathroom with Hot Shower',
            'Bathtub & Rain Shower',
            'Minibar & Espresso Maker',
            'In-Room Safe Deposit Box',
            'Executive Lounge Access',
            'Balcony with City/Garden View',
            '24/7 Room Service',
            'Bathrobes & Luxury Toiletries',
        ];

        return view('admin.rooms.edit', compact('room', 'roomTypes', 'defaultFacilities'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', Rule::unique('rooms')->ignore($room->id)],
            'room_type' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'bed_type' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'status' => ['required', 'in:available,unavailable'],
        ]);

        $imagePath = $room->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('rooms', 'public');
            $imagePath = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $room->update([
            'room_number' => $validated['room_number'],
            'room_type' => $validated['room_type'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'capacity' => $validated['capacity'],
            'bed_type' => $validated['bed_type'],
            'size' => $validated['size'],
            'facilities' => $validated['facilities'] ?? [],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room #' . $room->room_number . ' updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $hasActiveReservations = $room->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveReservations) {
            return back()->with('error', "Room #{$room->room_number} cannot be deleted because it has active/upcoming guest reservations. You may change its status to 'unavailable' instead.");
        }

        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room #' . $roomNumber . ' has been deleted.');
    }
}
