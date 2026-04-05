@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold text-deepred">{{ $title }}</h1>
            <p class="text-sm text-charcoal/70 mt-1">Manage records with search and quick actions.</p>
        </div>
        <a href="{{ route($routePrefix . '.create') }}" class="inline-flex items-center justify-center rounded-lg bg-terracotta px-4 py-2 text-white text-sm font-semibold hover:bg-deepred transition">
            + New
        </a>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-sand">
        <form method="GET" class="p-4 border-b border-sand flex items-center gap-3">
            <input type="text" name="q" value="{{ request('q') }}" class="w-full rounded-lg border-sand focus:border-terracotta focus:ring-terracotta" placeholder="Search...">
            <button class="rounded-lg bg-charcoal text-white px-4 py-2 text-sm">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#FCF9F4] text-left">
                    <tr>
                        @foreach($columns as $column)
                            <th class="px-4 py-3 font-semibold text-charcoal">{{ $column['label'] }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-semibold text-charcoal w-52">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="border-t border-sand/70">
                            @foreach($columns as $column)
                                @php
                                    $value = data_get($item, $column['key']);
                                    $type = $column['type'] ?? 'text';
                                @endphp
                                <td class="px-4 py-3 text-charcoal/90 align-top">
                                    @if($type === 'boolean')
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs {{ $value ? 'bg-olive/15 text-olive' : 'bg-deepred/10 text-deepred' }}">
                                            {{ $value ? 'Yes' : 'No' }}
                                        </span>
                                    @elseif($type === 'money')
                                        {{ number_format((float) $value, 2) }} TND
                                    @elseif($type === 'datetime' && $value)
                                        {{ \Illuminate\Support\Carbon::parse($value)->format('Y-m-d H:i') }}
                                    @else
                                        {{ $value ?: '—' }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route($routePrefix . '.show', $item) }}" class="px-3 py-1.5 rounded-md bg-sand text-charcoal">View</a>
                                    <a href="{{ route($routePrefix . '.edit', $item) }}" class="px-3 py-1.5 rounded-md bg-terracotta text-white">Edit</a>
                                    <form method="POST" action="{{ route($routePrefix . '.destroy', $item) }}" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-md bg-deepred text-white">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($columns) + 1 }}" class="px-4 py-6 text-center text-charcoal/60">{{ __('messages.empty_state') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-4 border-t border-sand">{{ $items->links() }}</div>
    </div>
</section>
@endsection
