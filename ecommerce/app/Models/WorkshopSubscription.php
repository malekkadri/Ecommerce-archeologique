<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['workshop_id', 'name', 'email', 'phone', 'seats', 'status', 'confirmed_at'];

    protected $casts = ['confirmed_at' => 'datetime'];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
