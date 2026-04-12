@props([
    'title' => null,
    'items' => [],
])

<div class="fo-reassurance">
    @if($title)
        <p class="font-semibold text-sm">{{ $title }}</p>
    @endif
    <ul class="mt-3 space-y-2 text-sm text-charcoal/80">
        @foreach($items as $item)
            <li class="flex items-start gap-2"><span class="text-olive mt-0.5">✓</span><span>{{ $item }}</span></li>
        @endforeach
    </ul>
</div>
