<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
                $setting = self::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Set a setting value by key.
     */
    public static function set($key, $value)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('setting_' . $key);
        Cache::forget('all_settings_map');

        return $setting;
    }

    /**
     * Get all settings as key => value array.
     */
    public static function getAll()
    {
        try {
            return Cache::rememberForever('all_settings_map', function () {
                return self::pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            return [];
        }
    }
}
