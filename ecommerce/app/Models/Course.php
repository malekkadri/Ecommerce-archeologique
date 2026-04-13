<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, SoftDeletes, HasLocalizedAttributes;

    protected $fillable = ['category_id', 'title', 'slug', 'summary', 'description', 'image_path', 'level', 'price', 'is_published', 'is_featured'];
    protected $casts = ['is_published' => 'boolean', 'is_featured' => 'boolean', 'price' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function mediaGallery()
    {
        return $this->morphMany(EntityMedia::class, 'mediable')->orderBy('sort_order');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function getTitleAttribute($value)
    {
        return $this->localizedValue($value);
    }

    public function getSummaryAttribute($value)
    {
        return $this->localizedValue($value);
    }

    public function getDescriptionAttribute($value)
    {
        return $this->localizedValue($value);
    }
}
