@extends('admin.master')
@section('content')

<div style="max-width: 1050px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">Frontend & Website Settings</h1>
            <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Customize website branding, contact numbers, address, and footer details dynamically</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('frontend.home') }}" target="_blank" class="btn-outline-admin" style="background: #fff;">
                <i class="fas fa-external-link-alt"></i> Preview Frontend
            </a>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert-success-admin" style="display: flex; align-items: center; gap: 10px; border-radius: 12px; padding: 14px 20px; font-weight: 600;">
            <i class="fas fa-check-circle" style="font-size: 18px;"></i>
            {{ session()->get('message') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        {{-- ─── SECTION 1: GENERAL BRANDING ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-globe"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">General Website Branding</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Brand name, logo text parts, and emergency hotline</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Full Website Name</label>
                    <input name="site_name" type="text" value="{{ $settings['site_name'] ?? 'SwiftBus' }}" class="admin-input" placeholder="e.g. SwiftBus">
                    <span style="font-size: 11px; color: var(--muted); margin-top: 4px; display: block;">Used in browser title and meta descriptions.</span>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">24/7 Helpline Number</label>
                    <input name="helpline" type="text" value="{{ $settings['helpline'] ?? '16374' }}" class="admin-input" placeholder="e.g. 16374">
                    <span style="font-size: 11px; color: var(--muted); margin-top: 4px; display: block;">Displayed on boarding passes and e-tickets.</span>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Logo Main Text (White Part)</label>
                    <input name="site_logo_prefix" type="text" value="{{ $settings['site_logo_prefix'] ?? 'Swift' }}" class="admin-input" placeholder="e.g. Swift">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Logo Suffix (Green/Accent Part)</label>
                    <input name="site_logo_suffix" type="text" value="{{ $settings['site_logo_suffix'] ?? 'Bus' }}" class="admin-input" placeholder="e.g. Bus">
                </div>

                <div class="admin-form-group" style="grid-column: 1 / -1;">
                    <label class="admin-label">Website Tagline / Mission</label>
                    <input name="site_tagline" type="text" value="{{ $settings['site_tagline'] ?? 'Fast, easy and reliable bus ticket booking system.' }}" class="admin-input" placeholder="e.g. Fast, easy and reliable bus ticket booking system.">
                </div>
            </div>
        </div>

        {{-- ─── SECTION 2: CONTACT SECTION (AS SHOWN IN SCREENSHOT) ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-headset"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">Contact Section Details</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Phone, Support Line, Email, and Physical Office Address displayed on landing page</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Primary Phone Number</label>
                    <div style="position: relative;">
                        <input name="contact_phone" type="text" value="{{ $settings['contact_phone'] ?? '01715484510' }}" class="admin-input" placeholder="e.g. 01715484510">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Support Line Number</label>
                    <div style="position: relative;">
                        <input name="contact_support_line" type="text" value="{{ $settings['contact_support_line'] ?? '01985562100' }}" class="admin-input" placeholder="e.g. 01985562100">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Official Contact Email</label>
                    <input name="contact_email" type="email" value="{{ $settings['contact_email'] ?? 'info@xyz.net' }}" class="admin-input" placeholder="e.g. info@xyz.net">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Section Pill / Badge</label>
                    <input name="contact_badge" type="text" value="{{ $settings['contact_badge'] ?? 'Get in touch' }}" class="admin-input" placeholder="e.g. Get in touch">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Section Heading</label>
                    <input name="contact_heading" type="text" value="{{ $settings['contact_heading'] ?? "We're here to help" }}" class="admin-input" placeholder="e.g. We're here to help">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Section Subtitle / Description</label>
                    <input name="contact_subtitle" type="text" value="{{ $settings['contact_subtitle'] ?? 'Have questions about your booking? Reach out anytime.' }}" class="admin-input" placeholder="e.g. Have questions about your booking? Reach out anytime.">
                </div>

                <div class="admin-form-group" style="grid-column: 1 / -1;">
                    <label class="admin-label">Office Physical Address</label>
                    <textarea name="contact_address" rows="3" class="admin-input" style="resize: vertical;" placeholder="e.g. Road-8, House-14, Sector-6, Softech Ltd, Dhaka-1230">{{ $settings['contact_address'] ?? "Road-8, House-14, Sector-6\nSoftech Ltd, Dhaka-1230" }}</textarea>
                </div>
            </div>
        </div>

        {{-- ─── SECTION 3: FOOTER & SOCIAL LINKS ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(168, 85, 247, 0.1); color: #a855f7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-share-nodes"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">Footer & Social Media</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Social channels and copyright notice in the frontend footer</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Facebook Page URL</label>
                    <input name="facebook_url" type="url" value="{{ $settings['facebook_url'] ?? 'https://www.facebook.com/s.sakib.47' }}" class="admin-input" placeholder="https://facebook.com/yourpage">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Twitter / X URL</label>
                    <input name="twitter_url" type="url" value="{{ $settings['twitter_url'] ?? 'https://twitter.com' }}" class="admin-input" placeholder="https://twitter.com/yourprofile">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Instagram URL</label>
                    <input name="instagram_url" type="url" value="{{ $settings['instagram_url'] ?? 'https://instagram.com' }}" class="admin-input" placeholder="https://instagram.com/yourprofile">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Footer Copyright Notice</label>
                    <input name="footer_copyright" type="text" value="{{ $settings['footer_copyright'] ?? '© ' . date('Y') . ' SwiftBus. All rights reserved.' }}" class="admin-input" placeholder="© 2026 SwiftBus. All rights reserved.">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 14px; padding-bottom: 40px;">
            <button type="submit" class="btn-primary-admin" style="padding: 13px 32px; font-size: 15px; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </form>
</div>

@endsection
