<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelDatabaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }
    public function test_users_rooms_and_reservations_data_and_relations(): void
    {
        // 1. Verify Users
        $admin = User::where('email', 'admin@hotel.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertEquals('admin', $admin->role);

        $user = User::where('email', 'user@hotel.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->isAdmin());
        $this->assertEquals('user', $user->role);

        // 2. Verify Rooms
        $rooms = Room::all();
        $this->assertGreaterThanOrEqual(4, $rooms->count());

        $room101 = Room::where('room_number', '101')->first();
        $this->assertNotNull($room101);
        $this->assertEquals('Standard', $room101->room_type);
        $this->assertEquals(350000.00, (float) $room101->price);
        $this->assertIsArray($room101->facilities);

        // 3. Verify Reservations and Relations
        $reservation = Reservation::with(['user', 'room'])->first();
        $this->assertNotNull($reservation);
        $this->assertInstanceOf(User::class, $reservation->user);
        $this->assertInstanceOf(Room::class, $reservation->room);
        $this->assertStringStartsWith('HTL-', $reservation->booking_code);

        // 4. Verify Overlap logic
        $checkIn = $reservation->check_in;
        $checkOut = $reservation->check_out;

        // Room of this reservation should NOT be available in availableBetween scope
        $availableRooms = Room::availableBetween($checkIn, $checkOut)->get();
        $this->assertFalse($availableRooms->contains('id', $reservation->room_id));

        // Other rooms SHOULD be available
        $availableRoomNumbers = $availableRooms->pluck('room_number')->toArray();
        $this->assertContains('101', $availableRoomNumbers);
        $this->assertContains('201', $availableRoomNumbers);
        $this->assertContains('301', $availableRoomNumbers);

        // Cancelled reservation should free the room
        $tempRes = Reservation::create([
            'booking_code' => Reservation::generateBookingCode(),
            'user_id' => $user->id,
            'room_id' => $room101->id,
            'check_in' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'check_out' => Carbon::now()->addDays(12)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'Test Guest',
            'guest_email' => 'guest@test.com',
            'guest_phone' => '0812345678',
            'total_nights' => 2,
            'total_price' => 700000.00,
            'status' => 'cancelled',
        ]);

        $this->assertTrue($room101->isAvailableForDates(Carbon::now()->addDays(10), Carbon::now()->addDays(12)));
        $tempRes->delete();
    }
}
