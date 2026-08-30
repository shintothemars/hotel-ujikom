<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the hotel homepage.
     */
    public function index()
    {
        $featuredRooms = Room::where('status', 'available')
            ->orderBy('price', 'asc')
            ->take(4)
            ->get();

        $defaultCheckIn = Carbon::now()->addDay()->format('Y-m-d');
        $defaultCheckOut = Carbon::now()->addDays(2)->format('Y-m-d');

        return view('home', compact('featuredRooms', 'defaultCheckIn', 'defaultCheckOut'));
    }
}
