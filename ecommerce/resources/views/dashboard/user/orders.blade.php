@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['title' => __('messages.my_orders')])
<section class="max-w-6xl mx-auto px-4 py-8 space-y-6">
    @include('components.front.dashboard-nav')

    @if($orders->isEmpty())
        @include('components.front.empty-state', ['title' => __('messages.no_orders_yet')])
    @else
        <div class="fo-table-wrap">
            <table class="min-w-full text-sm">
                <thead class="bg-sand/60">
                    <tr>
                        <th class="px-4 py-3 text-left">{{ __('messages.order_reference') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.order_status') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.total') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.date') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t border-sand/70">
                            <td class="px-4 py-3">{{ $order->reference }}</td>
                            <td class="px-4 py-3"><span class="fo-chip">{{ ucfirst($order->status) }}</span></td>
                            <td class="px-4 py-3">{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3"><a href="{{ route('orders.confirmation', $order) }}" class="text-deepred">{{ __('messages.view') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    @endif
</section>
@endsection
