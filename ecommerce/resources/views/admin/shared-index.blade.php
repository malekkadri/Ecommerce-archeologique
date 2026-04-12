@extends('layouts.admin')
@section('admin_title', $title)

@section('content')
<section class="space-y-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <p class="admin-kicker">Management</p>
            <h1 class="admin-title">{{ $title }}</h1>
            <p class="admin-subtitle">Search, review, and manage records with consistent actions.</p>
        </div>
        <a href="{{ route($routePrefix . '.create') }}" class="admin-btn admin-btn-primary">+ New</a>
    </div>

    <div class="admin-card overflow-hidden">
        <form method="GET" class="p-4 border-b border-slate-100 flex items-center gap-3">
            <input type="text" name="q" value="{{ request('q') }}" class="admin-input" placeholder="Search...">
            <button class="admin-btn admin-btn-secondary">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50/80 text-left">
                    <tr>
                        @foreach($columns as $column)
                            <th class="px-4 py-3 font-semibold text-slate-800">{{ $column['label'] }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-semibold text-slate-800 w-52">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition">
                            @foreach($columns as $column)
                                @php $value = data_get($item, $column['key']); $type = $column['type'] ?? 'text'; @endphp
                                <td class="px-4 py-3 text-slate-700 align-top">
                                    @if($type === 'boolean')
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $value ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $value ? 'Yes' : 'No' }}</span>
                                    @elseif($type === 'money')
                                        {{ number_format((float) $value, 2) }} TND
                                    @elseif($type === 'datetime' && $value)
                                        {{ \Illuminate\Support\Carbon::parse($value)->format('Y-m-d H:i') }}
                                    @elseif($type === 'image')
                                        @if($value)<img src="{{ $value }}" class="h-12 w-12 rounded object-cover border border-slate-200" alt="thumb">@else<span class="text-xs text-slate-400">—</span>@endif
                                    @else
                                        {{ $value ?: '—' }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route($routePrefix . '.show', $item) }}" class="admin-btn admin-btn-secondary">View</a>
                                    <a href="{{ route($routePrefix . '.edit', $item) }}" class="admin-btn admin-btn-primary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($columns) + 1 }}" class="px-4 py-6 text-center text-slate-500">{{ __('messages.empty_state') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-4 border-t border-slate-100">{{ $items->links() }}</div>
    </div>
</section>
@endsection
