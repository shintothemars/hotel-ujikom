<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelFrontendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected Room $room;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->admin = User::where('role', 'admin')->first();
        $this->user = User::where('role', 'user')->first();
        $this->room = Room::first();
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Find Your');
        $response->assertSee('Featured Rooms');
        $response->assertSee($this->room->name);
    }

    public function test_rooms_catalog_and_filters(): void
    {
        $response = $this->get('/rooms');
        $response->assertStatus(200);
        $response->assertSee('Find Your Perfect Room');
        $response->assertSee($this->room->name);

        // Test room type filter
        $responseFiltered = $this->get('/rooms?room_type=' . $this->room->room_type);
        $responseFiltered->assertStatus(200);
        $responseFiltered->assertSee($this->room->name);
    }

    public function test_room_detail_and_availability_checker(): void
    {
        $response = $this->get('/rooms/' . $this->room->id);
        $response->assertStatus(200);
        $response->assertSee($this->room->name);
        $response->assertSee($this->room->bed_type);

        // Test AJAX availability check
        $ajaxResponse = $this->postJson('/rooms/' . $this->room->id . '/check-availability', [
            'check_in' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'check_out' => Carbon::now()->addDays(12)->format('Y-m-d'),
        ]);

        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJson([
            'available' => true,
            'total_nights' => 2,
        ]);
    }

    public function test_authentication_and_role_redirection(): void
    {
        // 1. Regular User Login
        $userLogin = $this->post('/login', [
            'email' => 'user@hotel.com',
            'password' => 'password',
        ]);
        $userLogin->assertRedirect(route('home'));

        // 2. Admin User Login
        $this->post('/logout');
        $adminLogin = $this->post('/login', [
            'email' => 'admin@hotel.com',
            'password' => 'password',
        ]);
        $adminLogin->assertRedirect(route('admin.dashboard'));
    }

    public function test_end_to_end_booking_lifecycle(): void
    {
        $checkIn = Carbon::now()->addDays(20)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(23)->format('Y-m-d');

        // 1. Acting as regular user
        $this->actingAs($this->user);

        // 2. Open booking form (Step 1)
        $formResponse = $this->get('/booking/create?room_id=' . $this->room->id . '&check_in=' . $checkIn . '&check_out=' . $checkOut);
        $formResponse->assertStatus(200);
        $formResponse->assertSee($this->room->name);

        // 3. Confirm Step (Step 2)
        $confirmResponse = $this->post('/booking/confirm', [
            'room_id' => $this->room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'Jane Doe',
            'guest_email' => 'jane@example.com',
            'guest_phone' => '081234567890',
            'special_request' => 'Quiet room please',
        ]);
        $confirmResponse->assertStatus(200);
        $confirmResponse->assertSee('Confirm Your Reservation');
        $confirmResponse->assertSee('3 Night(s)');

        // 4. Store Reservation (Step 3)
        $storeResponse = $this->post('/booking/store', [
            'room_id' => $this->room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => 2,
            'children' => 0,
            'guest_name' => 'Jane Doe',
            'guest_email' => 'jane@example.com',
            'guest_phone' => '081234567890',
            'special_request' => 'Quiet room please',
        ]);

        $createdReservation = Reservation::where('guest_email', 'jane@example.com')->first();
        $this->assertNotNull($createdReservation);
        $this->assertEquals(3, $createdReservation->total_nights);
        $this->assertEquals((float) $this->room->price * 3, (float) $createdReservation->total_price);

        $storeResponse->assertRedirect(route('booking.success', $createdReservation->booking_code));

        // 5. View Voucher Ticket
        $voucherResponse = $this->get('/booking/success/' . $createdReservation->booking_code);
        $voucherResponse->assertStatus(200);
        $voucherResponse->assertSee($createdReservation->booking_code);
        $voucherResponse->assertSee('Jane Doe');

        // 6. View My Reservations
        $myBookingsResponse = $this->get('/my-reservations');
        $myBookingsResponse->assertStatus(200);
        $myBookingsResponse->assertSee($createdReservation->booking_code);
    }

    public function test_admin_authorization_and_management(): void
    {
        // 1. Regular User cannot access Admin
        $this->actingAs($this->user);
        $forbiddenResponse = $this->get('/admin');
        $forbiddenResponse->assertRedirect(route('home'));

        // 2. Admin can access Admin Dashboard
        $this->actingAs($this->admin);
        $adminDashboard = $this->get('/admin');
        $adminDashboard->assertStatus(200);
        $adminDashboard->assertSee('Executive Dashboard');
        $adminDashboard->assertSee('Total Rooms');

        // 3. Admin can create new room
        $createRoom = $this->post('/admin/rooms', [
            'room_number' => '501',
            'room_type' => 'Suite',
            'name' => 'Penthouse Imperial',
            'description' => 'Ultra luxurious penthouse with private rooftop.',
            'price' => 2500000.00,
            'capacity' => 4,
            'bed_type' => 'Super King Bed',
            'size' => 120,
            'facilities' => ['Private Pool', 'Butler Service', 'Jacuzzi'],
            'status' => 'available',
        ]);
        $createRoom->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseHas('rooms', ['room_number' => '501']);

        // 4. Admin can update room
        $newRoom = Room::where('room_number', '501')->first();
        $updateRoom = $this->put('/admin/rooms/' . $newRoom->id, [
            'room_number' => '501',
            'room_type' => 'Suite',
            'name' => 'Penthouse Imperial Updated',
            'description' => 'Updated luxury description.',
            'price' => 2800000.00,
            'capacity' => 5,
            'bed_type' => 'Super King Bed',
            'size' => 130,
            'facilities' => ['Private Pool', 'Butler Service'],
            'status' => 'available',
        ]);
        $updateRoom->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseHas('rooms', ['name' => 'Penthouse Imperial Updated']);

        // 5. Admin can delete room
        $deleteRoom = $this->delete('/admin/rooms/' . $newRoom->id);
        $deleteRoom->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseMissing('rooms', ['id' => $newRoom->id]);

        // 6. Admin can update reservation status
        $demoReservation = Reservation::first();
        $statusUpdate = $this->patch('/admin/reservations/' . $demoReservation->id . '/status', [
            'status' => 'completed',
        ]);
        $statusUpdate->assertRedirect();
        $this->assertEquals('completed', $demoReservation->fresh()->status);
    }
}
