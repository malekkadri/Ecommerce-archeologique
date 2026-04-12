@extends('layouts.admin')
@section('admin_title', $title)

@section('content')
<section class="space-y-4">
    <div class="flex items-center justify-between gap-4">
        <h1 class="admin-title">{{ $title }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route($routePrefix . '.edit', $item) }}" class="admin-btn admin-btn-primary">Edit</a>
            <a href="{{ route($routePrefix . '.index') }}" class="admin-btn admin-btn-secondary">Back</a>
        </div>
    </div>

    <div class="admin-card divide-y divide-slate-100">
        @foreach($displayFields as $field)
            @php $value = data_get($item, $field['key']); $type = $field['type'] ?? 'text'; @endphp
            <div class="grid md:grid-cols-3 gap-3 p-4">
                <div class="text-sm font-semibold text-slate-900">{{ $field['label'] }}</div>
                <div class="md:col-span-2 text-sm text-slate-700 whitespace-pre-line">
                    @if($type === 'boolean')
                        <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $value ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $value ? 'Yes' : 'No' }}</span>
                    @elseif($type === 'money')
                        {{ number_format((float) $value, 2) }} TND
                    @elseif($type === 'datetime' && $value)
                        {{ \Illuminate\Support\Carbon::parse($value)->format('Y-m-d H:i') }}
                    @elseif($type === 'image')
                        @if($value)<img src="{{ $value }}" class="h-24 w-24 rounded object-cover border border-slate-200" alt="Image">@else — @endif
                    @else
                        {{ $value ?: '—' }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
