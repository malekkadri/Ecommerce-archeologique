<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'title', 'slug', 'summary', 'description', 'location', 'starts_at', 'ends_at', 'capacity', 'reserved_count', 'price', 'is_featured'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'is_featured' => 'boolean', 'price' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(WorkshopBooking::class);
    }

    public function hasAvailableSeats()
    {
        return $this->reserved_count < $this->capacity;
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
