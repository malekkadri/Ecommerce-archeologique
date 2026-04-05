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
            'recentOrders' => $user->orders()->latest()->take(5)->get(),
        ]);
    }

    public function orders()
    {
        $orders = auth()->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('dashboard.user.orders', compact('orders'));
    }
}
