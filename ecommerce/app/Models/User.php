<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_VENDOR = 'vendor';
    public const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function workshopBookings()
    {
        return $this->hasMany(WorkshopBooking::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isVendor()
    {
        return $this->role === self::ROLE_VENDOR;
    }
}
