<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAll();
        return view('admin.pages.Settings.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'site_name',
            'site_logo_prefix',
            'site_logo_suffix',
            'site_tagline',
            'helpline',
            'contact_badge',
            'contact_heading',
            'contact_subtitle',
            'contact_phone',
            'contact_support_line',
            'contact_email',
            'contact_address',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'footer_copyright',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        // Clear all relevant caches
        Cache::forget('all_settings_map');

        return redirect()->route('admin.settings')->with('message', 'Frontend settings have been updated successfully!');
    }
}
