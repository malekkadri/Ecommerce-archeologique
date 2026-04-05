<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('dashboard.user.index', [
            'ordersCount' => $user->orders()->count(),
            'bookingsCount' => $user->workshopBookings()->count(),
            'coursesCount' => $user->enrollments()->count(),
        ]);
    }
}
