@extends('layouts.admin')
@section('admin_title', $title)

@section('content')
<section class="space-y-4">
    <div>
        <p class="admin-kicker">Edition</p>
        <h1 class="admin-title">{{ $title }}</h1>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ $method === 'POST' ? route($routePrefix . '.store') : route($routePrefix . '.update', $item) }}" class="admin-card p-6 grid md:grid-cols-2 gap-4">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        @foreach($fields as $field)
            @php
                $fieldName = $field['name'];
                $fieldType = $field['type'] ?? 'text';
                $fieldValue = old($fieldName, $item->{$fieldName} ?? null);
                if ($fieldType === 'datetime-local' && !empty($fieldValue)) {
                    $fieldValue = \Illuminate\Support\Carbon::parse($fieldValue)->format('Y-m-d\\TH:i');
                }
            @endphp

            <div class="{{ in_array($fieldType, ['textarea', 'gallery']) ? 'md:col-span-2' : '' }}">
                @if($fieldType === 'checkbox')
                    <label class="inline-flex items-center gap-2 mt-8"><input type="checkbox" name="{{ $fieldName }}" value="1" @checked(old($fieldName, $item->{$fieldName} ?? false))><span>{{ $field['label'] }}</span></label>
                @elseif($fieldType === 'image')
                    <label class="admin-label">{{ $field['label'] }}</label>
                    <input type="file" name="{{ $fieldName }}" class="admin-input" accept="image/*">
                    @php $current = $fieldName === 'featured_image' ? ($item->featured_image_url ?? null) : ($item->image_url ?? null); @endphp
                    @if($current)
                        <img src="{{ $current }}" class="mt-3 h-24 w-24 rounded object-cover border border-slate-200" alt="Current image">
                        <label class="mt-2 inline-flex items-center gap-2 text-sm"><input type="checkbox" name="remove_image" value="1"> Remove image</label>
                    @endif
                @elseif($fieldType === 'gallery')
                    <label class="admin-label">{{ $field['label'] }}</label>
                    <input type="file" name="gallery_images[]" multiple class="admin-input" accept="image/*">
                    @if(method_exists($item, 'mediaGallery') && $item->relationLoaded('mediaGallery') && $item->mediaGallery->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-3">
                            @foreach($item->mediaGallery as $media)
                                <label class="border border-slate-200 rounded p-2 text-xs">
                                    <img src="{{ $media->url }}" class="h-20 w-full object-cover rounded mb-2" alt="Gallery image">
                                    <span class="inline-flex items-center gap-1"><input type="checkbox" name="remove_gallery[]" value="{{ $media->id }}"> Remove</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                @else
                    <label class="admin-label">{{ $field['label'] }}</label>
                    @if($fieldType === 'select')
                        <select name="{{ $fieldName }}" class="admin-input">
                            <option value="">--</option>
                            @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>{{ $optionLabel }}</option>
                            @endforeach
                        </select>
                    @elseif($fieldType === 'textarea')
                        <textarea name="{{ $fieldName }}" rows="5" class="admin-input">{{ $fieldValue }}</textarea>
                    @else
                        <input type="{{ $fieldType }}" name="{{ $fieldName }}" value="{{ $fieldType === 'password' ? '' : $fieldValue }}" @if(!empty($field['step'])) step="{{ $field['step'] }}" @endif @if(!empty($field['min'])) min="{{ $field['min'] }}" @endif class="admin-input">
                    @endif
                @endif
            </div>
        @endforeach

        <div class="md:col-span-2 flex items-center gap-3 pt-2">
            <button class="admin-btn admin-btn-primary">{{ __('messages.save') }}</button>
            <a href="{{ route($routePrefix . '.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</section>
@endsection
