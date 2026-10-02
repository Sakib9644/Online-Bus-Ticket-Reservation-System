<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\HeroSlider;
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
        $uploadDir = public_path('uploads/settings');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Handle Hero Slider Images (multiple upload)
        if ($request->hasFile('slider_images')) {
            $sliderDir = public_path('uploads/sliders');
            if (!file_exists($sliderDir)) {
                mkdir($sliderDir, 0777, true);
            }

            $titles = array_filter(explode("\n", $request->input('slider_titles', '')));
            $currentMaxOrder = HeroSlider::max('sort_order') ?? 0;

            foreach ($request->file('slider_images') as $idx => $file) {
                if ($file->isValid() && $file->getSize() <= 5 * 1024 * 1024) {
                    $filename = 'slider_' . time() . '_' . $idx . '.' . $file->getClientOriginalExtension();
                    $file->move($sliderDir, $filename);

                    HeroSlider::create([
                        'image_path' => 'uploads/sliders/' . $filename,
                        'title' => trim($titles[$idx] ?? ''),
                        'sort_order' => $currentMaxOrder + $idx + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Handle Hero Background Image
        if ($request->hasFile('hero_image')) {
            $request->validate(['hero_image' => 'image|mimes:jpeg,png,jpg,webp|max:5120']);
            $file = $request->file('hero_image');
            $filename = 'hero_bg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            Setting::set('hero_image', 'uploads/settings/' . $filename);
        }

        // Handle Site Logo Image
        if ($request->hasFile('site_logo_image')) {
            $request->validate(['site_logo_image' => 'image|mimes:jpeg,png,jpg,webp,svg|max:2048']);
            $file = $request->file('site_logo_image');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            Setting::set('site_logo_image', 'uploads/settings/' . $filename);
        }

        // Option to reset logo image back to text branding
        if ($request->has('remove_logo_image') && $request->input('remove_logo_image') == '1') {
            Setting::set('site_logo_image', null);
        }

        // Checkbox fields (toggle switches)
        $checkboxFields = [
            'sslcommerz_active',
            'sslcommerz_sandbox',
            'bkash_active',
            'bkash_sandbox',
            'nagad_active',
            'rocket_active',
        ];

        foreach ($checkboxFields as $checkbox) {
            Setting::set($checkbox, $request->has($checkbox) ? '1' : '0');
        }

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
            // SSLCommerz
            'sslcommerz_store_id',
            'sslcommerz_store_password',
            // bKash API credentials
            'bkash_app_key',
            'bkash_app_secret',
            'bkash_username',
            'bkash_password',
            'bkash_number',
            'bkash_type',
            'bkash_instructions',
            // Nagad
            'nagad_number',
            'nagad_type',
            'nagad_instructions',
            // Rocket
            'rocket_number',
            'rocket_type',
            'rocket_instructions',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        // Clear all relevant caches
        Cache::forget('all_settings_map');

        return redirect()->route('admin.settings')->with('message', 'Website images and payment configurations updated successfully!');
    }

    /**
     * Delete a hero slider image.
     */
    public function deleteSlider($id)
    {
        $slider = HeroSlider::findOrFail($id);

        // Delete the physical file
        $filePath = public_path($slider->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $slider->delete();

        return redirect()->route('admin.settings')->with('message', 'Slider image removed successfully.');
    }
}
