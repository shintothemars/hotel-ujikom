<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations for admin management.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['room', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Display the specified reservation details.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['room', 'user'])->findOrFail($id);

        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Update the reservation status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
        ]);

        $reservation = Reservation::findOrFail($id);
        $oldStatus = $reservation->status;
        $reservation->update([
            'status' => $request->status,
        ]);

        return back()->with('success', "Reservation #{$reservation->booking_code} status updated from " . ucfirst($oldStatus) . " to " . ucfirst($request->status) . ".");
    }
}
