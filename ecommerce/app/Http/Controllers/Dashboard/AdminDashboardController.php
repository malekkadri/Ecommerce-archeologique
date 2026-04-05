<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Content;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Workshop;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.index', [
            'usersCount' => User::count(),
            'vendorsCount' => User::where('role', User::ROLE_VENDOR)->count(),
            'productsCount' => Product::count(),
            'ordersCount' => Order::count(),
            'coursesCount' => Course::count(),
            'workshopsCount' => Workshop::count(),
            'contentCount' => Content::count(),
            'inquiriesCount' => ContactInquiry::count(),
            'recentOrders' => Order::with('user')->latest()->take(8)->get(),
            'recentInquiries' => ContactInquiry::latest()->take(8)->get(),
            'lowStockProducts' => Product::where('stock', '<=', 5)->where('is_active', true)->latest()->take(8)->get(),
            'upcomingWorkshops' => Workshop::where('starts_at', '>=', now())->orderBy('starts_at')->take(8)->get(),
        ]);
    }
}
