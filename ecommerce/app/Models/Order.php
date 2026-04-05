<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reference', 'status', 'payment_status', 'subtotal', 'total', 'currency'];
    protected $casts = ['subtotal' => 'decimal:2', 'total' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
}
