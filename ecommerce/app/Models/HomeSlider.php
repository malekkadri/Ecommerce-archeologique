<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeSlider extends Model
{
    use HasFactory, HasLocalizedAttributes;

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return str_starts_with($this->image_path, 'http')
            ? $this->image_path
            : Storage::url($this->image_path);
    }

    public function getTitleAttribute($value)
    {
        return $this->localizedValue($value);
    }

    public function getSubtitleAttribute($value)
    {
        return $this->localizedValue($value);
    }
}
