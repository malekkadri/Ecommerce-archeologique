@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-semibold text-deepred">{{ $title }}</h1>

    @if($errors->any())
        <div class="mt-4 rounded-xl border border-deepred/40 bg-deepred/5 p-4 text-sm text-deepred">
            <p class="font-semibold">Please review the form:</p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $method === 'POST' ? route($routePrefix . '.store') : route($routePrefix . '.update', $item) }}" class="mt-6 bg-white rounded-xl border border-sand p-6 grid md:grid-cols-2 gap-4">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        @foreach($fields as $field)
            @php
                $fieldName = $field['name'];
                $fieldType = $field['type'] ?? 'text';
                $fieldValue = old($fieldName, $item->{$fieldName} ?? null);
                if ($fieldType === 'datetime-local' && !empty($fieldValue)) {
                    $fieldValue = \Illuminate\Support\Carbon::parse($fieldValue)->format('Y-m-d\\TH:i');
                }
            @endphp

            <div class="{{ in_array($fieldType, ['textarea']) ? 'md:col-span-2' : '' }}">
                @if($fieldType === 'checkbox')
                    <label class="inline-flex items-center gap-2 mt-8">
                        <input type="checkbox" name="{{ $fieldName }}" value="1" @checked(old($fieldName, $item->{$fieldName} ?? false)) class="rounded border-sand text-terracotta focus:ring-terracotta">
                        <span class="text-sm text-charcoal">{{ $field['label'] }}</span>
                    </label>
                @else
                    <label class="block text-sm font-medium text-charcoal mb-1">{{ $field['label'] }} @if(!empty($field['required']))<span class="text-deepred">*</span>@endif</label>

                    @if($fieldType === 'select')
                        <select name="{{ $fieldName }}" class="w-full rounded-lg border-sand focus:border-terracotta focus:ring-terracotta">
                            <option value="">--</option>
                            @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>{{ $optionLabel }}</option>
                            @endforeach
                        </select>
                    @elseif($fieldType === 'textarea')
                        <textarea name="{{ $fieldName }}" rows="6" class="w-full rounded-lg border-sand focus:border-terracotta focus:ring-terracotta">{{ $fieldValue }}</textarea>
                    @else
                        <input
                            type="{{ $fieldType }}"
                            name="{{ $fieldName }}"
                            value="{{ $fieldType === 'password' ? '' : $fieldValue }}"
                            @if(!empty($field['step'])) step="{{ $field['step'] }}" @endif
                            @if(!empty($field['min'])) min="{{ $field['min'] }}" @endif
                            class="w-full rounded-lg border-sand focus:border-terracotta focus:ring-terracotta"
                        >
                    @endif
                @endif
            </div>
        @endforeach

        <div class="md:col-span-2 flex items-center gap-3 pt-2">
            <button class="rounded-lg bg-terracotta px-4 py-2 text-white font-semibold hover:bg-deepred transition">{{ __('messages.save') }}</button>
            <a href="{{ route($routePrefix . '.index') }}" class="rounded-lg bg-sand px-4 py-2 text-charcoal font-semibold">Cancel</a>
        </div>
    </form>
</section>
@endsection
