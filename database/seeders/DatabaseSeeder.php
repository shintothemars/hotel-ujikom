<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Default Administrator
        $admin = User::updateOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Hotel Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Default Regular User
        $user = User::updateOrCreate(
            ['email' => 'user@hotel.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // 3. Seed Rooms
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard',
                'name' => 'Standard Room',
                'description' => 'A comfortable and minimalist room with essential modern amenities, ideal for solo travelers or couples looking for a restful stay.',
                'price' => 350000.00,
                'capacity' => 2,
                'bed_type' => 'Queen Bed',
                'size' => 24,
                'facilities' => [
                    'Free High-Speed Wi-Fi',
                    'Air Conditioning',
                    'Flat-screen Smart TV',
                    'Private Bathroom with Hot Shower',
                    'Complimentary Bottled Water',
                    'Electric Kettle & Tea/Coffee',
                ],
                'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                'status' => 'available',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Deluxe',
                'name' => 'Deluxe Room',
                'description' => 'Spacious deluxe sanctuary featuring elegant wooden furnishings, stunning city views, premium bed linens, and a dedicated work desk.',
                'price' => 550000.00,
                'capacity' => 2,
                'bed_type' => 'King Bed',
                'size' => 32,
                'facilities' => [
                    'Panoramic City View',
                    'Free High-Speed Wi-Fi',
                    'Smart 50" 4K TV',
                    'Bathtub & Rain Shower',
                    'Minibar & Espresso Maker',
                    'In-Room Safe Deposit Box',
                    'Bathrobes & Luxury Toiletries',
                ],
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'status' => 'available',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Executive',
                'name' => 'Executive Room',
                'description' => 'Tailored for discerning business and leisure guests with exclusive lounge privileges, ergonomic lounge seating, and refined modern aesthetics.',
                'price' => 750000.00,
                'capacity' => 3,
                'bed_type' => 'King Bed',
                'size' => 40,
                'facilities' => [
                    'Executive Lounge Access',
                    'High-Speed Wi-Fi & Workstation',
                    'Marble Bathroom with Deep Soaking Tub',
                    'Complimentary Evening Cocktails',
                    'Nespresso Coffee Machine',
                    'Daily Laundry Service',
                    '24-Hour In-Room Dining',
                ],
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'status' => 'available',
            ],
            [
                'room_number' => '301',
                'room_type' => 'Suite',
                'name' => 'Luxury Suite',
                'description' => 'The pinnacle of opulence featuring a separate living salon, dining area, master bedroom with panoramic balcony, and personalized butler service.',
                'price' => 1200000.00,
                'capacity' => 4,
                'bed_type' => 'King Bed',
                'size' => 60,
                'facilities' => [
                    'Separate Living & Dining Room',
                    'Private Balcony with Sunset View',
                    'Whirlpool Jacuzzi Bathtub',
                    '24/7 Dedicated Butler Service',
                    'Complimentary Mini Bar & Champagne',
                    'Walk-in Closet',
                    'Harman Kardon Sound System',
                ],
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                'status' => 'available',
            ],
        ];

        $seededRooms = [];
        foreach ($rooms as $roomData) {
            $seededRooms[] = Room::updateOrCreate(
                ['room_number' => $roomData['room_number']],
                $roomData
            );
        }

        // 4. Seed Demo Reservation for User to populate metrics & booking views
        if (!empty($seededRooms)) {
            $checkIn = Carbon::now()->addDays(2)->format('Y-m-d');
            $checkOut = Carbon::now()->addDays(4)->format('Y-m-d');
            $nights = 2;
            $selectedRoom = $seededRooms[1]; // Deluxe Room 102
            $totalPrice = (float) $selectedRoom->price * $nights;

            Reservation::updateOrCreate(
                ['booking_code' => 'HTL-' . date('Ymd') . '-DEMO'],
                [
                    'user_id' => $user->id,
                    'room_id' => $selectedRoom->id,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'adults' => 2,
                    'children' => 0,
                    'guest_name' => $user->name,
                    'guest_email' => $user->email,
                    'guest_phone' => '+62 812-3456-7890',
                    'special_request' => 'High floor room with non-smoking preference, please.',
                    'total_nights' => $nights,
                    'total_price' => $totalPrice,
                    'status' => 'confirmed',
                ]
            );
        }
    }
}
