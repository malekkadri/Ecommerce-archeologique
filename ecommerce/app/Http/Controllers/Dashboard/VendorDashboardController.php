<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendorProfile;

        return view('dashboard.vendor.index', [
            'productsCount' => $vendor ? $vendor->products()->count() : 0,
            'ordersCount' => $vendor ? OrderItem::where('vendor_profile_id', $vendor->id)->count() : 0,
            'pendingProducts' => $vendor ? $vendor->products()->where('is_active', false)->count() : 0,
        ]);
    }
}
