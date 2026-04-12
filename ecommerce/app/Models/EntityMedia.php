<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EntityMedia extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'alt_text', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
