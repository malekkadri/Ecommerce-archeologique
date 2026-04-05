<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopBooking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'workshop_id', 'seats', 'status', 'confirmed_at'];
    protected $casts = ['confirmed_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function workshop() { return $this->belongsTo(Workshop::class); }
}
