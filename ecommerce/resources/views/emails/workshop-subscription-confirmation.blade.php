<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.workshop_subscription_subject', ['title' => $subscription->workshop->title]) }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #1f2937;">
    <h2>{{ __('messages.workshop_subscription_thanks', ['name' => $subscription->name]) }}</h2>
    <p>{{ __('messages.workshop_subscription_confirmed_text') }}</p>

    <ul>
        <li><strong>{{ __('messages.workshop') }}:</strong> {{ $subscription->workshop->title }}</li>
        <li><strong>{{ __('messages.date') }}:</strong> {{ optional($subscription->workshop->starts_at)->format('M d, Y H:i') }}</li>
        <li><strong>{{ __('messages.seats') }}:</strong> {{ $subscription->seats }}</li>
        <li><strong>{{ __('messages.location') }}:</strong> {{ $subscription->workshop->location }}</li>
    </ul>

    <p>{{ __('messages.workshop_subscription_followup') }}</p>
</body>
</html>
