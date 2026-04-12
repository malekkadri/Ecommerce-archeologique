@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['variant' => 'commerce', 'kicker' => __('messages.checkout'), 'title' => __('messages.checkout'), 'subtitle' => 'Finalize billing and delivery details with clear summary controls and confidence cues.', 'meta' => [__('messages.payment_method'), __('messages.cash_on_delivery'), 'Secure confirmation']])
<section class="max-w-6xl mx-auto px-4 py-8" data-page="checkout">
    <form action="{{ route('checkout.place') }}" method="POST" class="grid lg:grid-cols-3 gap-6">
        @csrf
        <div class="lg:col-span-2 fo-panel p-6 space-y-6">
            <div>
                <h2 class="text-xl font-semibold">{{ __('messages.billing_info') }}</h2>
                <p class="text-sm text-charcoal/70 mt-1">Use the best contact details for fulfillment updates and delivery continuity.</p>
                <div class="grid md:grid-cols-2 gap-3 mt-3">
                    <input name="billing_name" value="{{ old('billing_name', auth()->user()->name) }}" class="fo-input" placeholder="{{ __('messages.name') }}">
                    <input name="billing_email" value="{{ old('billing_email', auth()->user()->email) }}" class="fo-input" placeholder="Email">
                    <input name="billing_phone" value="{{ old('billing_phone') }}" class="fo-input" placeholder="{{ __('messages.phone') }}">
                    <input name="billing_address" value="{{ old('billing_address') }}" class="fo-input md:col-span-2" placeholder="{{ __('messages.address') }}">
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold">{{ __('messages.shipping_info') }}</h2>
                <p class="text-sm text-charcoal/70 mt-1">Delivery details are used exactly as submitted to reduce coordination friction.</p>
                <div class="grid md:grid-cols-2 gap-3 mt-3">
                    <input name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" class="fo-input" placeholder="{{ __('messages.name') }}">
                    <input name="shipping_phone" value="{{ old('shipping_phone') }}" class="fo-input" placeholder="{{ __('messages.phone') }}">
                    <input name="shipping_address" value="{{ old('shipping_address') }}" class="fo-input md:col-span-2" placeholder="{{ __('messages.address') }}">
                </div>
            </div>

            <div class="rounded-xl bg-sand/60 p-4 text-sm">
                <p class="font-semibold">{{ __('messages.payment_method') }}</p>
                <p class="mt-1">{{ __('messages.cash_on_delivery') }}</p>
                <p class="text-charcoal/70 mt-1">{{ __('messages.cod_note') }}</p>
            </div>

            <div>
                <textarea name="notes" rows="3" class="fo-textarea" placeholder="{{ __('messages.order_notes') }}">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="fo-panel p-6 h-fit sticky top-24 fo-sticky-desktop" id="checkout-summary">
            <h3 class="font-semibold text-lg">{{ __('messages.order_summary') }}</h3>
            <div class="mt-4 space-y-2 text-sm">
                @foreach($cartItems as $item)
                    <div class="flex justify-between gap-2 border-b border-sand/60 pb-2">
                        <span class="pr-2">{{ optional($item->product)->name }} × {{ $item->quantity }}</span>
                        <span class="whitespace-nowrap">{{ number_format($item->unit_price * $item->quantity, 2) }} TND</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-sand/70 flex justify-between font-semibold text-lg">
                <span>{{ __('messages.total') }}</span>
                <span>{{ number_format($subtotal, 2) }} TND</span>
            </div>
            @include('components.front.reassurance-list', ['tone' => 'commerce', 'items' => ['Order reference appears immediately after placing the order.', 'Status remains visible in your dashboard.', 'No additional hidden charges after this step.']])
            <button class="mt-5 w-full fo-btn fo-btn-primary" data-cta="checkout-place-order">{{ __('messages.place_order') }}</button>
        </div>
    </form>
</section>
@endsection
