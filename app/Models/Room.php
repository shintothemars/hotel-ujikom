<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'room_number',
        'room_type',
        'name',
        'description',
        'price',
        'capacity',
        'bed_type',
        'size',
        'facilities',
        'image',
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
            'price' => 'decimal:2',
            'facilities' => 'array',
            'capacity' => 'integer',
            'size' => 'integer',
        ];
    }

    /**
     * Get all reservations for the room.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Scope rooms that are generally set to 'available' status.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope rooms that do not have active overlapping reservations between $checkIn and $checkOut.
     *
     * Overlap condition:
     * existing.check_in < requested_check_out AND existing.check_out > requested_check_in
     *
     * Active statuses: pending, confirmed, completed
     */
    public function scopeAvailableBetween(Builder $query, $checkIn, $checkOut, $excludeReservationId = null): Builder
    {
        return $query->where('status', 'available')
            ->whereDoesntHave('reservations', function (Builder $q) use ($checkIn, $checkOut, $excludeReservationId) {
                $q->whereIn('status', ['pending', 'confirmed', 'completed'])
                  ->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn);

                if ($excludeReservationId) {
                    $q->where('id', '!=', $excludeReservationId);
                }
            });
    }

    /**
     * Check whether this specific room is available for given dates.
     */
    public function isAvailableForDates($checkIn, $checkOut, $excludeReservationId = null): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        $query = $this->reservations()
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return !$query->exists();
    }

    /**
     * Helper to get formatted price (IDR).
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }
}
