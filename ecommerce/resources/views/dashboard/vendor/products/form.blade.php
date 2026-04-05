<section class="max-w-3xl mx-auto px-4 py-12">
    <form method="post" action="{{ $action }}" class="bg-white p-6 rounded-2xl space-y-4">
        @csrf
        @if($method==='PUT') @method('PUT') @endif

        @if($errors->any())
            <div class="bg-deepred/10 text-deepred rounded-lg p-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <input name="name" class="w-full border rounded px-3 py-2" placeholder="{{ __('messages.name') }}" value="{{ old('name',optional($product)->name) }}">
        <input name="slug" class="w-full border rounded px-3 py-2" placeholder="slug" value="{{ old('slug',optional($product)->slug) }}">
        <input name="sku" class="w-full border rounded px-3 py-2" placeholder="SKU" value="{{ old('sku',optional($product)->sku) }}">
        <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" placeholder="{{ __('messages.description') }}">{{ old('description',optional($product)->description) }}</textarea>
        <div class="grid md:grid-cols-2 gap-3">
            <input name="price" class="w-full border rounded px-3 py-2" placeholder="{{ __('messages.price') }}" value="{{ old('price',optional($product)->price) }}">
            <input name="stock" class="w-full border rounded px-3 py-2" placeholder="{{ __('messages.stock') }}" value="{{ old('stock',optional($product)->stock) }}">
        </div>

        <select name="category_id" class="w-full border rounded px-3 py-2">
            <option value="">{{ __('messages.select_category') }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', optional($product)->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', optional($product)->is_active ?? true))>
            <span>{{ __('messages.active_product') }}</span>
        </label>

        <button class="bg-terracotta text-white rounded px-4 py-2">{{ __('messages.save') }}</button>
    </form>
</section>
