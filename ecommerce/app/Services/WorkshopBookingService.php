<?php

namespace App\Services;

use App\Models\Workshop;
use App\Models\WorkshopBooking;
use App\Models\WorkshopSubscription;
use Illuminate\Support\Facades\DB;

class WorkshopBookingService
{
    public function reserve(Workshop $workshop, $userId, $seats)
    {
        return DB::transaction(function () use ($workshop, $userId, $seats) {
            $workshop->refresh();
            if (($workshop->reserved_count + $seats) > $workshop->capacity) {
                return null;
            }

            $booking = WorkshopBooking::create([
                'user_id' => $userId,
                'workshop_id' => $workshop->id,
                'seats' => $seats,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            $workshop->increment('reserved_count', $seats);

            return $booking;
        });
    }

    public function subscribe(Workshop $workshop, array $data)
    {
        return DB::transaction(function () use ($workshop, $data) {
            $workshop->refresh();

            if (($workshop->reserved_count + $data['seats']) > $workshop->capacity) {
                return null;
            }

            $subscription = WorkshopSubscription::create([
                'workshop_id' => $workshop->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'seats' => $data['seats'],
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            $workshop->increment('reserved_count', $data['seats']);

            return $subscription;
        });
    }
}
