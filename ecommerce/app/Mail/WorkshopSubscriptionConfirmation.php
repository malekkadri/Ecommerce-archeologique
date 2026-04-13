<?php

namespace App\Mail;

use App\Models\WorkshopSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkshopSubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct(WorkshopSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject(__('messages.workshop_subscription_subject', ['title' => $this->subscription->workshop->title]))
            ->view('emails.workshop-subscription-confirmation');
    }
}
