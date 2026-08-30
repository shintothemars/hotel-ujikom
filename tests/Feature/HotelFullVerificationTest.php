<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelFullVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /**
     * TEST 1: Register User
     */
    public function test_1_register_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'Alice Green',
            'email' => 'alice@hotel.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'email' => 'alice@hotel.com',
            'role' => 'user', // Ensure registered users always get 'user' role
        ]);
    }

    /**
     * TEST 2: Login User
     */
    public function test_2_login_user(): void
    {
        $response = $this->post('/login', [
            'email' => 'user@hotel.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    /**
     * TEST 3: Login Admin
     */
    public function test_3_login_admin(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@hotel.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    /**
     * TEST 4: Homepage
     */
    public function test_4_homepage(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Find Your');
        $response->assertSee('Perfect Stay');
        $response->assertSee('Featured Rooms');
        $response->assertSee('Everything You Need');
        $response->assertSee('Why Stay With Us?');
    }

    /**
     * TEST 5: Room List
     */
    public function test_5_room_list(): void
    {
        $response = $this->get('/rooms');
        $response->assertStatus(200);
        $response->assertSee('Find Your Perfect Room');
        $response->assertSee('Standard Room');
        $response->assertSee('Deluxe Room');
    }

    /**
     * TEST 6: Room Detail
     */
    public function test_6_room_detail(): void
    {
        $room = Room::first();
        $response = $this->get('/rooms/' . $room->id);
        $response->assertStatus(200);
        $response->assertSee($room->name);
        $response->assertSee($room->bed_type);
        $response->assertSee('Suite Description');
    }

    /**
     * TEST 7: Search Room with Filters
     */
    public function test_7_search_room(): void
    {
        $response = $this->get('/rooms?room_type=Deluxe&adults=2');
        $response->assertStatus(200);
        $response->assertSee('Deluxe Room');
    }

    /**
     * TEST 8: Booking Step 1 (Create Form)
     */
    public function test_8_booking_form(): void
    {
        $user = User::where('role', 'user')->first();
        $room = Room::first();

        $response = $this->actingAs($user)->get('/booking/create?room_id=' . $room->id);
        $response->assertStatus(200);
        $response->assertSee('Book Your Stay');
        $response->assertSee($room->name);
    }

    /**
     * TEST 9: Confirmation Step 2
     */
    public function test_9_confirmation(): void
    {
        $user = User::where('role', 'user')->first();
        $room = Room::first();

        $checkIn = Carbon::now()->addDays(5)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(7)->format('Y-m-d');

        $response = $this->actingAs($user)->post('/booking/confirm', [
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'John Doe',
            'guest_email' => 'user@hotel.com',
            'guest_phone' => '+62 812-3456-7890',
            'special_request' => 'Ocean view preferred',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Confirm Your Reservation');
        $response->assertSee('2 Night(s)');
    }

    /**
     * TEST 10: Booking Success & Ticket Voucher
     */
    public function test_10_booking_success_ticket(): void
    {
        $user = User::where('role', 'user')->first();
        $room = Room::first();

        $checkIn = Carbon::now()->addDays(15)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(17)->format('Y-m-d');

        $this->actingAs($user)->post('/booking/store', [
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'John Doe',
            'guest_email' => 'user@hotel.com',
            'guest_phone' => '+62 812-3456-7890',
        ]);

        $reservation = Reservation::where('guest_name', 'John Doe')->latest()->first();
        $this->assertNotNull($reservation);

        $ticketResponse = $this->actingAs($user)->get('/booking/success/' . $reservation->booking_code);
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($reservation->booking_code);
        $ticketResponse->assertSee('Official Stay Voucher');
        $ticketResponse->assertSee('Print Ticket');
    }

    /**
     * TEST 11: My Reservations
     */
    public function test_11_my_reservations(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->get('/my-reservations');
        $response->assertStatus(200);
        $response->assertSee('My Reservations');
    }

    /**
     * TEST 12: Admin Dashboard
     */
    public function test_12_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Executive Dashboard');
        $response->assertSee('Total Rooms');
        $response->assertSee('Available');
    }

    /**
     * TEST 13: Add Room
     */
    public function test_13_add_room(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/rooms', [
            'room_number' => '405',
            'room_type' => 'Executive',
            'name' => 'Executive Panorama Suite',
            'description' => 'Sweeping skyline vistas with dedicated executive club lounge access.',
            'price' => 850000.00,
            'capacity' => 3,
            'bed_type' => 'King Bed',
            'size' => 45,
            'facilities' => ['Free High-Speed Wi-Fi', 'Executive Lounge Access'],
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseHas('rooms', ['room_number' => '405']);
    }

    /**
     * TEST 14: Edit Room
     */
    public function test_14_edit_room(): void
    {
        $admin = User::where('role', 'admin')->first();
        $room = Room::where('room_number', '101')->first();

        $response = $this->actingAs($admin)->put('/admin/rooms/' . $room->id, [
            'room_number' => '101',
            'room_type' => 'Standard',
            'name' => 'Standard Deluxe Cozy Room',
            'description' => 'Updated luxury description.',
            'price' => 380000.00,
            'capacity' => 2,
            'bed_type' => 'Queen Bed',
            'size' => 26,
            'facilities' => ['Free High-Speed Wi-Fi'],
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.rooms.index'));
        $this->assertEquals('Standard Deluxe Cozy Room', $room->fresh()->name);
    }

    /**
     * TEST 15: Delete Room with Safeguard
     */
    public function test_15_delete_room(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        // Create an unbooked room
        $tempRoom = Room::create([
            'room_number' => '999',
            'room_type' => 'Standard',
            'name' => 'Temporary Room',
            'description' => 'Temp',
            'price' => 300000.00,
            'capacity' => 2,
            'bed_type' => 'Twin Bed',
            'size' => 20,
            'status' => 'available',
        ]);

        $response = $this->actingAs($admin)->delete('/admin/rooms/' . $tempRoom->id);
        $response->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseMissing('rooms', ['id' => $tempRoom->id]);
    }

    /**
     * TEST 16: Admin Reservation Management
     */
    public function test_16_admin_reservation_list(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/reservations');
        $response->assertStatus(200);
        $response->assertSee('Guest Reservations');
    }

    /**
     * TEST 17: Update Reservation Status
     */
    public function test_17_update_reservation_status(): void
    {
        $admin = User::where('role', 'admin')->first();
        $reservation = Reservation::first();

        $response = $this->actingAs($admin)->patch('/admin/reservations/' . $reservation->id . '/status', [
            'status' => 'completed',
        ]);

        $response->assertRedirect();
        $this->assertEquals('completed', $reservation->fresh()->status);
    }

    /**
     * TEST 18: Admin Users Management & Role Update
     */
    public function test_18_admin_users_and_role(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('Registered Users');
        $response->assertSee($user->name);

        // Update role to admin
        $updateRole = $this->actingAs($admin)->patch('/admin/users/' . $user->id . '/role', [
            'role' => 'admin',
        ]);
        $updateRole->assertRedirect();
        $this->assertEquals('admin', $user->fresh()->role);
    }

    /**
     * TEST 19: User Attempts to Access Admin (Authorization Check)
     */
    public function test_19_regular_user_cannot_access_admin(): void
    {
        $user = User::where('email', 'user@hotel.com')->first();
        $user->update(['role' => 'user']); // Ensure user role

        $response = $this->actingAs($user)->get('/admin');
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Access denied. You do not have administrator privileges.');
    }

    /**
     * TEST 20: Double Booking Prevention (Overlap Check)
     */
    public function test_20_double_booking_prevention(): void
    {
        $user = User::where('role', 'user')->first();
        $room = Room::where('room_number', '102')->first();

        // There is an existing confirmed reservation on Room 102 from Seeder (days +2 to +4)
        $checkIn = Carbon::now()->addDays(2)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(4)->format('Y-m-d');

        // Attempting to book overlapping dates should be blocked with exact error message
        $conflictResponse = $this->actingAs($user)->post('/booking/confirm', [
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'Another Guest',
            'guest_email' => 'another@example.com',
            'guest_phone' => '0899999999',
        ]);

        $conflictResponse->assertRedirect();
        $conflictResponse->assertSessionHas('error', 'Room is unavailable for the selected dates.');
    }
}
