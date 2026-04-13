<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkshopBookingRequest;
use App\Http\Requests\StoreWorkshopSubscriptionRequest;
use App\Mail\WorkshopSubscriptionConfirmation;
use App\Models\Workshop;
use App\Models\WorkshopBooking;
use App\Services\WorkshopBookingService;
use Illuminate\Support\Facades\Mail;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::where('starts_at', '>=', now()->subDays(1))->orderBy('starts_at')->paginate(9);
        return view('workshops.index', compact('workshops'));
    }

    public function show($slug)
    {
        $workshop = Workshop::with('mediaGallery')->where('slug', $slug)->firstOrFail();
        return view('workshops.show', compact('workshop'));
    }

    public function book(StoreWorkshopBookingRequest $request, WorkshopBookingService $service)
    {
        $workshop = Workshop::findOrFail($request->workshop_id);
        $booking = $service->reserve($workshop, $request->user()->id, (int) $request->seats);

        if (!$booking) {
            return back()->with('error', __('messages.booking_unavailable'));
        }

        return back()->with('success', __('messages.booking_confirmed'));
    }

    public function subscribe(StoreWorkshopSubscriptionRequest $request, WorkshopBookingService $service)
    {
        $workshop = Workshop::findOrFail($request->workshop_id);
        $subscription = $service->subscribe($workshop, $request->validated());

        if (!$subscription) {
            return back()->with('error', __('messages.booking_unavailable'));
        }

        Mail::to($subscription->email)->send(new WorkshopSubscriptionConfirmation($subscription));

        return back()->with('success', __('messages.workshop_subscription_confirmed'));
    }

    public function history()
    {
        $bookings = WorkshopBooking::with('workshop')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('dashboard.user.bookings', compact('bookings'));
    }
}
