<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, HasLocalizedAttributes;

    protected $fillable = ['name', 'slug', 'type', 'image_path'];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function getNameAttribute($value)
    {
        return $this->localizedValue($value);
    }
}
