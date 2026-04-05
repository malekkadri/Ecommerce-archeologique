<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['vendor_profile_id', 'category_id', 'name', 'slug', 'description', 'price', 'stock', 'sku', 'is_featured', 'is_active'];
    protected $casts = ['price' => 'decimal:2', 'is_featured' => 'boolean', 'is_active' => 'boolean'];

    public function vendorProfile() { return $this->belongsTo(VendorProfile::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
