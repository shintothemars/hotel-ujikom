<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'guest_name',
        'guest_email',
        'guest_phone',
        'special_request',
        'total_nights',
        'total_price',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'adults' => 'integer',
            'children' => 'integer',
            'total_nights' => 'integer',
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room associated with the reservation.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Generate unique booking code.
     * Format: HTL-YYYYMMDD-XXXX
     */
    public static function generateBookingCode(): string
    {
        do {
            $code = 'HTL-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Calculate total nights between check_in and check_out.
     */
    public static function calculateTotalNights($checkIn, $checkOut): int
    {
        $start = Carbon::parse($checkIn)->startOfDay();
        $end = Carbon::parse($checkOut)->startOfDay();

        $nights = $start->diffInDays($end, false);

        return max(1, (int) $nights);
    }

    /**
     * Calculate total price from room price and total nights.
     */
    public static function calculateTotalPrice($pricePerNight, int $totalNights): float
    {
        return (float) $pricePerNight * $totalNights;
    }

    /**
     * Check if a room is available for given dates.
     */
    public static function isRoomAvailable($roomId, $checkIn, $checkOut, $excludeReservationId = null): bool
    {
        $query = static::where('room_id', $roomId)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return !$query->exists();
    }

    /**
     * Helper to get formatted total price (IDR).
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }
}
