<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show step 1 booking form for a selected room.
     */
    public function create(Request $request)
    {
        $roomId = $request->input('room_id');
        $room = Room::where('status', 'available')->findOrFail($roomId);

        $checkIn = $request->input('check_in', Carbon::now()->addDay()->format('Y-m-d'));
        $checkOut = $request->input('check_out', Carbon::now()->addDays(2)->format('Y-m-d'));
        $adults = max(1, (int) $request->input('adults', 1));
        $children = max(0, (int) $request->input('children', 0));

        // Check availability
        $isAvailable = $room->isAvailableForDates($checkIn, $checkOut);
        $totalNights = Reservation::calculateTotalNights($checkIn, $checkOut);
        $totalPrice = Reservation::calculateTotalPrice($room->price, $totalNights);

        $user = Auth::user();

        return view('booking.create', compact(
            'room',
            'checkIn',
            'checkOut',
            'adults',
            'children',
            'isAvailable',
            'totalNights',
            'totalPrice',
            'user'
        ));
    }

    /**
     * Show step 2 review and confirmation page.
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'special_request' => ['nullable', 'string', 'max:1000'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Check guest capacity
        $totalGuests = (int) $validated['adults'] + (int) ($validated['children'] ?? 0);
        if ($totalGuests > $room->capacity) {
            return back()->withInput()->with('error', "The selected room has a maximum capacity of {$room->capacity} guests.");
        }

        // Check date availability (Anti-Double Booking)
        if (!$room->isAvailableForDates($validated['check_in'], $validated['check_out'])) {
            return back()->withInput()->with('error', 'Room is unavailable for the selected dates.');
        }

        $totalNights = Reservation::calculateTotalNights($validated['check_in'], $validated['check_out']);
        $totalPrice = Reservation::calculateTotalPrice($room->price, $totalNights);

        return view('booking.confirm', [
            'room' => $room,
            'bookingData' => $validated,
            'totalNights' => $totalNights,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * Store reservation in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'special_request' => ['nullable', 'string', 'max:1000'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Final server-side availability check
        if (!$room->isAvailableForDates($validated['check_in'], $validated['check_out'])) {
            return redirect()->route('rooms.show', $room->id)
                ->with('error', 'Room is unavailable for the selected dates. Please select other dates.');
        }

        $totalNights = Reservation::calculateTotalNights($validated['check_in'], $validated['check_out']);
        $totalPrice = Reservation::calculateTotalPrice($room->price, $totalNights);
        $bookingCode = Reservation::generateBookingCode();

        $reservation = Reservation::create([
            'booking_code' => $bookingCode,
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'special_request' => $validated['special_request'] ?? null,
            'total_nights' => $totalNights,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        return redirect()->route('booking.success', $reservation->booking_code)
            ->with('success', 'Your reservation has been successfully confirmed!');
    }

    /**
     * Show official booking ticket / voucher.
     */
    public function success($bookingCode)
    {
        $reservation = Reservation::with(['room', 'user'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Authorization: only the owner or an admin can view the voucher
        if (Auth::check() && Auth::id() !== $reservation->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to view this reservation voucher.');
        }

        return view('booking.success', compact('reservation'));
    }

    /**
     * Show logged in user's reservation history.
     */
    public function myReservations()
    {
        $reservations = Reservation::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('booking.my_reservations', compact('reservations'));
    }

    /**
     * Cancel an existing reservation.
     */
    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (in_array($reservation->status, ['pending', 'confirmed'])) {
            $reservation->update(['status' => 'cancelled']);
            return back()->with('success', 'Reservation #' . $reservation->booking_code . ' has been cancelled.');
        }

        return back()->with('error', 'This reservation cannot be cancelled at this stage.');
    }
}
