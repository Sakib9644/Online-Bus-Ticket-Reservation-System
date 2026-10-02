<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'title', 'subtitle', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all active sliders ordered by sort_order.
     */
    public static function getActive()
    {
        return self::where('is_active', true)->orderBy('sort_order')->get();
    }
}
