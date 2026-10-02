@extends('admin.master')
@section('content')

<div style="max-width: 1080px; margin: 0 auto; padding-bottom: 60px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; margin: 0;">Website & Payment Settings</h1>
            <p style="color: var(--muted); font-size: 14px; margin-top: 4px; margin-bottom: 0;">Configure website branding, hero banner image, SSLCommerz, and Mobile Banking (bKash, Nagad, Rocket)</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('frontend.home') }}" target="_blank" class="btn-outline-admin" style="background: #fff;">
                <i class="fas fa-external-link-alt"></i> Preview Website
            </a>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert-success-admin" style="display: flex; align-items: center; gap: 10px; border-radius: 12px; padding: 14px 20px; font-weight: 600; margin-bottom: 24px;">
            <i class="fas fa-check-circle" style="font-size: 18px;"></i>
            {{ session()->get('message') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ─── SECTION 1: WEBSITE IMAGES & BRANDING MEDIA ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-images"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">Website Images & Media</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Upload your custom Hero Background banner and Website Logo</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                {{-- Hero Background Image --}}
                <div class="admin-form-group">
                    <label class="admin-label" style="font-weight: 700;">Hero Banner Background Image</label>
                    <div style="margin-bottom: 12px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #0b0d11; height: 160px; display: flex; align-items: center; justify-content: center; position: relative;">
                        @php
                            $currentHero = setting('hero_image') ? asset(setting('hero_image')) : asset('frontend/images/hero_bg.png');
                        @endphp
                        <img src="{{ $currentHero }}" alt="Hero Background Preview" id="heroPreviewImg" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #fff; font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;">Current Hero Banner</div>
                    </div>
                    <input type="file" name="hero_image" accept="image/*" class="admin-input" onchange="previewImage(this, 'heroPreviewImg')">
                    <span style="font-size: 11px; color: var(--muted); margin-top: 4px; display: block;">Recommended size: 1920x1080px (JPG, PNG, WebP). Max 5MB.</span>
                </div>

                {{-- Website Logo Image --}}
                <div class="admin-form-group">
                    <label class="admin-label" style="font-weight: 700;">Website Logo (Optional Image)</label>
                    <div style="margin-bottom: 12px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #1e293b; height: 160px; display: flex; align-items: center; justify-content: center; position: relative;">
                        @if(setting('site_logo_image'))
                            <img src="{{ asset(setting('site_logo_image')) }}" alt="Site Logo Preview" id="logoPreviewImg" style="max-height: 80px; max-width: 90%; object-fit: contain;">
                            <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #fff; font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;">Custom Logo Active</div>
                        @else
                            <div id="logoPreviewImg" style="text-align: center; color: #fff; font-family: 'Poppins', sans-serif;">
                                <div style="font-size: 24px; font-weight: 800;">
                                    {{ setting('site_logo_prefix', 'Swift') }}<span style="color: #a2e043;">{{ setting('site_logo_suffix', 'Bus') }}</span>
                                </div>
                                <span style="font-size: 11px; color: #94a3b8;">Default Text Logo Active</span>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="site_logo_image" accept="image/*" class="admin-input" onchange="previewImage(this, 'logoPreviewImg')">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                        <span style="font-size: 11px; color: var(--muted);">PNG or SVG with transparent background recommended.</span>
                        @if(setting('site_logo_image'))
                            <label style="font-size: 11px; color: #ef4444; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                <input type="checkbox" name="remove_logo_image" value="1"> Revert to Text Logo
                            </label>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── SECTION 2: PAYMENT GATEWAYS & MOBILE BANKING METHODS ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">Payment Gateway & Mobile Banking</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Enable or disable payment options. When active, they appear in passenger checkout.</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">

                {{-- 1. SSLCOMMERZ --}}
                <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; overflow: hidden;">
                    <div style="background: #f1f5f9; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        

