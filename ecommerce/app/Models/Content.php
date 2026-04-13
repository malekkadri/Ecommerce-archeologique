<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    use HasFactory, SoftDeletes, HasLocalizedAttributes;

    protected $fillable = ['author_id', 'category_id', 'title', 'slug', 'excerpt', 'body', 'type', 'featured_image', 'is_featured', 'published_at'];
    protected $casts = ['is_featured' => 'boolean', 'published_at' => 'datetime'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return null;
        }

        return str_starts_with($this->featured_image, 'http') ? $this->featured_image : Storage::url($this->featured_image);
    }

    public function getTitleAttribute($value)
    {
        return $this->localizedValue($value);
    }

    public function getExcerptAttribute($value)
    {
        return $this->localizedValue($value);
    }

    public function getBodyAttribute($value)
    {
        return $this->localizedValue($value);
    }
}
