<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with real-time stats from database.
     */
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $confirmedReservations = Reservation::where('status', 'confirmed')->count();
        $completedReservations = Reservation::where('status', 'completed')->count();
        $totalUsers = User::count();
        $totalRevenue = Reservation::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        $recentReservations = Reservation::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $roomsSummary = Room::withCount(['reservations' => function ($q) {
            $q->whereIn('status', ['confirmed', 'completed']);
        }])->orderBy('reservations_count', 'desc')->take(4)->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'completedReservations',
            'totalUsers',
            'totalRevenue',
            'recentReservations',
            'roomsSummary'
        ));
    }
}
