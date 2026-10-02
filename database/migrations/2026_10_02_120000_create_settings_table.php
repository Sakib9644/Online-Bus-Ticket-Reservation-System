<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default initial settings
        $defaults = [
            'site_name' => 'SwiftBus',
            'site_logo_prefix' => 'Swift',
            'site_logo_suffix' => 'Bus',
            'site_tagline' => 'Fast, easy and reliable bus ticket booking system.',
            'contact_badge' => 'Get in touch',
            'contact_heading' => "We're here to help",
            'contact_subtitle' => 'Have questions about your booking? Reach out anytime.',
            'contact_phone' => '01715484510',
            'contact_support_line' => '01985562100',
            'contact_email' => 'info@xyz.net',
            'contact_address' => "Road-8, House-14, Sector-6\nSoftech Ltd, Dhaka-1230",
            'helpline' => '16374',
            'facebook_url' => 'https://www.facebook.com/s.sakib.47',
            'twitter_url' => 'https://twitter.com',
            'instagram_url' => 'https://instagram.com',
            'footer_copyright' => '© ' . date('Y') . ' SwiftBus. All rights reserved.',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
