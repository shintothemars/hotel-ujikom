<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms with live filtering.
     */
    public function index(Request $request)
    {
        $query = Room::query();

        // 1. Filter by room status
        $query->where('status', 'available');

        // 2. Filter by Room Type
        if ($request->filled('room_type') && $request->room_type !== 'All') {
            $query->where('room_type', $request->room_type);
        }

        // 3. Filter by Capacity
        $adults = (int) $request->input('adults', 1);
        $children = (int) $request->input('children', 0);
        $totalGuests = $adults + $children;

        if ($totalGuests > 1) {
            $query->where('capacity', '>=', $totalGuests);
        }

        // 4. Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // 5. Filter by Date Availability (Overlap check)
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            $query->availableBetween($checkIn, $checkOut);
        }

        // 6. Sorting
        $sort = $request->input('sort', 'price_asc');
        switch ($sort) {
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'capacity_desc':
                $query->orderBy('capacity', 'desc');
                break;
            case 'price_asc':
            default:
                $query->orderBy('price', 'asc');
                break;
        }

        $rooms = $query->paginate(9)->withQueryString();
        $roomTypes = ['Standard', 'Deluxe', 'Executive', 'Suite'];

        return view('rooms.index', compact('rooms', 'roomTypes', 'checkIn', 'checkOut', 'adults', 'children'));
    }

    /**
     * Display the specified room details.
     */
    public function show(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $checkIn = $request->input('check_in', Carbon::now()->addDay()->format('Y-m-d'));
        $checkOut = $request->input('check_out', Carbon::now()->addDays(2)->format('Y-m-d'));
        $adults = (int) $request->input('adults', 2);
        $children = (int) $request->input('children', 0);

        $isAvailable = null;
        $totalNights = 1;
        $totalPrice = (float) $room->price;

        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            $isAvailable = $room->isAvailableForDates($checkIn, $checkOut);
            $totalNights = Reservation::calculateTotalNights($checkIn, $checkOut);
            $totalPrice = Reservation::calculateTotalPrice($room->price, $totalNights);
        }

        $similarRooms = Room::where('id', '!=', $room->id)
            ->where('status', 'available')
            ->where('room_type', $room->room_type)
            ->take(3)
            ->get();

        if ($similarRooms->isEmpty()) {
            $similarRooms = Room::where('id', '!=', $room->id)
                ->where('status', 'available')
                ->take(3)
                ->get();
        }

        return view('rooms.show', compact(
            'room',
            'checkIn',
            'checkOut',
            'adults',
            'children',
            'isAvailable',
            'totalNights',
            'totalPrice',
            'similarRooms'
        ));
    }

    /**
     * AJAX endpoint to check availability for selected room and dates.
     */
    public function checkAvailability(Request $request, $id)
    {
        $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $room = Room::findOrFail($id);
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        $isAvailable = $room->isAvailableForDates($checkIn, $checkOut);
        $totalNights = Reservation::calculateTotalNights($checkIn, $checkOut);
        $totalPrice = Reservation::calculateTotalPrice($room->price, $totalNights);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Room is available for selected dates!' : 'Sorry, this room is already booked for these dates.',
            'total_nights' => $totalNights,
            'total_price' => $totalPrice,
            'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
        ]);
    }
}
