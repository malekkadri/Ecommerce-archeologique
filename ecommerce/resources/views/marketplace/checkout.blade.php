@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-semibold">{{ __('messages.checkout') }}</h1>

    <form action="{{ route('checkout.place') }}" method="POST" class="mt-6 grid lg:grid-cols-3 gap-6">
        @csrf
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 space-y-6">
            <div>
                <h2 class="text-xl font-semibold">{{ __('messages.billing_info') }}</h2>
                <div class="grid md:grid-cols-2 gap-3 mt-3">
                    <input name="billing_name" value="{{ old('billing_name', auth()->user()->name) }}" class="rounded-lg border px-3 py-2" placeholder="{{ __('messages.name') }}">
                    <input name="billing_email" value="{{ old('billing_email', auth()->user()->email) }}" class="rounded-lg border px-3 py-2" placeholder="Email">
                    <input name="billing_phone" value="{{ old('billing_phone') }}" class="rounded-lg border px-3 py-2" placeholder="{{ __('messages.phone') }}">
                    <input name="billing_address" value="{{ old('billing_address') }}" class="rounded-lg border px-3 py-2 md:col-span-2" placeholder="{{ __('messages.address') }}">
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold">{{ __('messages.shipping_info') }}</h2>
                <div class="grid md:grid-cols-2 gap-3 mt-3">
                    <input name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" class="rounded-lg border px-3 py-2" placeholder="{{ __('messages.name') }}">
                    <input name="shipping_phone" value="{{ old('shipping_phone') }}" class="rounded-lg border px-3 py-2" placeholder="{{ __('messages.phone') }}">
                    <input name="shipping_address" value="{{ old('shipping_address') }}" class="rounded-lg border px-3 py-2 md:col-span-2" placeholder="{{ __('messages.address') }}">
                </div>
            </div>

            <div>
                <textarea name="notes" rows="3" class="w-full rounded-lg border px-3 py-2" placeholder="{{ __('messages.order_notes') }}">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 h-fit">
            <h3 class="font-semibold">{{ __('messages.order_summary') }}</h3>
            <div class="mt-4 space-y-2 text-sm">
                @foreach($cartItems as $item)
                    <div class="flex justify-between gap-2">
                        <span>{{ optional($item->product)->name }} × {{ $item->quantity }}</span>
                        <span>{{ number_format($item->unit_price * $item->quantity, 2) }} TND</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t flex justify-between font-semibold">
                <span>{{ __('messages.total') }}</span>
                <span>{{ number_format($subtotal, 2) }} TND</span>
            </div>
            <button class="mt-5 w-full bg-terracotta text-white py-2 rounded-lg">{{ __('messages.place_order') }}</button>
        </div>
    </form>
</section>
@endsection
