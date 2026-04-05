@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-3xl font-semibold text-deepred">{{ $title }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route($routePrefix . '.edit', $item) }}" class="rounded-lg bg-terracotta text-white px-4 py-2 text-sm">Edit</a>
            <a href="{{ route($routePrefix . '.index') }}" class="rounded-lg bg-sand text-charcoal px-4 py-2 text-sm">Back</a>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-sand divide-y divide-sand">
        @foreach($displayFields as $field)
            @php
                $value = data_get($item, $field['key']);
                $type = $field['type'] ?? 'text';
            @endphp
            <div class="grid md:grid-cols-3 gap-3 p-4">
                <div class="text-sm font-semibold text-charcoal">{{ $field['label'] }}</div>
                <div class="md:col-span-2 text-sm text-charcoal/90 whitespace-pre-line">
                    @if($type === 'boolean')
                        <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $value ? 'bg-olive/15 text-olive' : 'bg-deepred/10 text-deepred' }}">{{ $value ? 'Yes' : 'No' }}</span>
                    @elseif($type === 'money')
                        {{ number_format((float) $value, 2) }} TND
                    @elseif($type === 'datetime' && $value)
                        {{ \Illuminate\Support\Carbon::parse($value)->format('Y-m-d H:i') }}
                    @else
                        {{ $value ?: '—' }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
