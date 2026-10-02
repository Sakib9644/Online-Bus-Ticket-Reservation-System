@extends('admin.master')
@section('content')

<div style="max-width: 1080px; margin: 0 auto; padding-bottom: 60px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; margin: 0;">Website & Payment Settings</h1>
            <p style="color: var(--muted); font-size: 14px; margin-top: 4px; margin-bottom: 0;">Configure website branding, hero banner, SSLCommerz, and Mobile Banking (bKash, Nagad, Rocket)</p>
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

        {{-- ─── SECTION 1: WEBSITE IMAGES ─── --}}
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
                        @php $currentHero = setting('hero_image') ? asset(setting('hero_image')) : asset('frontend/images/hero_bg.png'); @endphp
                        <img src="{{ $currentHero }}" alt="Hero Background Preview" id="heroPreviewImg" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #fff; font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;">Current Hero Banner</div>
                    </div>
                    <input type="file" name="hero_image" accept="image/*" class="admin-input" onchange="previewImage(this, 'heroPreviewImg')">
                    <span style="font-size: 11px; color: var(--muted); margin-top: 4px; display: block;">Recommended: 1920x1080px (JPG, PNG, WebP). Max 5MB.</span>
                </div>

                {{-- Website Logo --}}
                <div class="admin-form-group">
                    <label class="admin-label" style="font-weight: 700;">Website Logo (Optional Image)</label>
                    <div style="margin-bottom: 12px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #1e293b; height: 160px; display: flex; align-items: center; justify-content: center; position: relative;">
                        @if(setting('site_logo_image'))
                            <img src="{{ asset(setting('site_logo_image')) }}" alt="Site Logo Preview" id="logoPreviewImg" style="max-height: 80px; max-width: 90%; object-fit: contain;">
                            <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #fff; font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;">Custom Logo Active</div>
                        @else
                            <div id="logoPreviewImg" style="text-align: center; color: #fff; font-family: 'Poppins', sans-serif;">
                                <div style="font-size: 24px; font-weight: 800;">{{ setting('site_logo_prefix', 'Swift') }}<span style="color: #a2e043;">{{ setting('site_logo_suffix', 'Bus') }}</span></div>
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

        {{-- ─── SECTION 2: PAYMENT GATEWAYS ─── --}}
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
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: #034982; color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 12px;">SSL</div>
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">SSLCommerz Gateway</div>
                                <div style="font-size: 11.5px; color: var(--muted);">Visa, Mastercard, AMEX, Internet Banking</div>
                            </div>
                        </div>
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; font-weight: 700; color: #0f172a; background: #fff; padding: 6px 14px; border-radius: 30px; border: 1px solid #cbd5e1;">
                            <input type="checkbox" name="sslcommerz_active" value="1" {{ setting('sslcommerz_active', '1') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #10b981; cursor: pointer;">
                            <span>Enable SSLCommerz</span>
                        </label>
                    </div>
                    <div style="padding: 18px 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Store ID</label>
                                <input name="sslcommerz_store_id" type="text" value="{{ $settings['sslcommerz_store_id'] ?? env('SSLCZ_STORE_ID', '') }}" class="admin-input" placeholder="e.g. swiftbus60a12b3">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Store Password</label>
                                <input name="sslcommerz_store_password" type="password" value="{{ $settings['sslcommerz_store_password'] ?? env('SSLCZ_STORE_PASSWORD', '') }}" class="admin-input" placeholder="••••••••••••">
                            </div>
                            <div class="admin-form-group" style="margin: 0; display: flex; flex-direction: column; justify-content: center;">
                                <label class="admin-label">Gateway Mode</label>
                                <label style="display: flex; align-items: center; gap: 8px; margin-top: 8px; font-size: 13px; font-weight: 600; color: #475569; cursor: pointer;">
                                    <input type="checkbox" name="sslcommerz_sandbox" value="1" {{ setting('sslcommerz_sandbox', '1') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #3b82f6;">
                                    <span>Sandbox (Test Mode)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. BKASH --}}
                <div style="border: 1.5px solid #fecdd3; border-radius: 14px; overflow: hidden;">
                    <div style="background: #fff1f2; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="padding: 4px 10px; background: #e2136e; color: #fff; border-radius: 8px; font-weight: 900; font-size: 13px;">bKash</div>
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #881337;">bKash Tokenized Checkout</div>
                                <div style="font-size: 11.5px; color: #9f1239;">Direct bKash payment via API — no manual TrxID needed</div>
                            </div>
                        </div>
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; font-weight: 700; color: #881337; background: #fff; padding: 6px 14px; border-radius: 30px; border: 1px solid #fda4af;">
                            <input type="checkbox" name="bkash_active" value="1" {{ setting('bkash_active', '1') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #e2136e; cursor: pointer;">
                            <span>Enable bKash</span>
                        </label>
                    </div>
                    <div style="padding: 18px 20px;">
                        {{-- API Credentials --}}
                        <div style="font-size: 11px; font-weight: 800; color: #e2136e; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-key"></i> API Credentials (Tokenized Checkout)
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">App Key</label>
                                <input name="bkash_app_key" type="text" value="{{ $settings['bkash_app_key'] ?? '4f6o0cjiki2rfm34kfdadl1eqq' }}" class="admin-input" placeholder="bKash App Key">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">App Secret</label>
                                <input name="bkash_app_secret" type="password" value="{{ $settings['bkash_app_secret'] ?? '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b' }}" class="admin-input" placeholder="••••••••••••">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Username</label>
                                <input name="bkash_username" type="text" value="{{ $settings['bkash_username'] ?? 'sandboxTokenizedUser02' }}" class="admin-input" placeholder="API Username">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Password</label>
                                <input name="bkash_password" type="password" value="{{ $settings['bkash_password'] ?? 'sandboxTokenizedUser02@12345' }}" class="admin-input" placeholder="••••••••••••">
                            </div>
                        </div>
                        {{-- Mode & Display --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; padding-top: 14px; border-top: 1px solid #fecdd3;">
                            <div class="admin-form-group" style="margin: 0; display: flex; flex-direction: column; justify-content: center;">
                                <label class="admin-label">Gateway Mode</label>
                                <label style="display: flex; align-items: center; gap: 8px; margin-top: 8px; font-size: 13px; font-weight: 600; color: #475569; cursor: pointer;">
                                    <input type="checkbox" name="bkash_sandbox" value="1" {{ setting('bkash_sandbox', '1') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #e2136e;">
                                    <span>Sandbox (Test Mode)</span>
                                </label>
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Merchant Number (Display)</label>
                                <input name="bkash_number" type="text" value="{{ $settings['bkash_number'] ?? '01715484510' }}" class="admin-input" placeholder="e.g. 01715484510">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Account Type</label>
                                <select name="bkash_type" class="admin-input">
                                    <option value="Merchant" {{ ($settings['bkash_type'] ?? 'Merchant') == 'Merchant' ? 'selected' : '' }}>Merchant</option>
                                    <option value="Personal" {{ ($settings['bkash_type'] ?? '') == 'Personal' ? 'selected' : '' }}>Personal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. NAGAD --}}
                <div style="border: 1.5px solid #fed7aa; border-radius: 14px; overflow: hidden;">
                    <div style="background: #fff7ed; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="padding: 4px 10px; background: #ed1c24; color: #fff; border-radius: 8px; font-weight: 900; font-size: 13px;">Nagad</div>
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #9a3412;">Nagad Mobile Banking</div>
                                <div style="font-size: 11.5px; color: #c2410c;">Send Money / Merchant Payment</div>
                            </div>
                        </div>
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; font-weight: 700; color: #9a3412; background: #fff; padding: 6px 14px; border-radius: 30px; border: 1px solid #fdba74;">
                            <input type="checkbox" name="nagad_active" value="1" {{ setting('nagad_active', '1') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #ed1c24; cursor: pointer;">
                            <span>Enable Nagad</span>
                        </label>
                    </div>
                    <div style="padding: 18px 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Nagad Account Number</label>
                                <input name="nagad_number" type="text" value="{{ $settings['nagad_number'] ?? '01855621000' }}" class="admin-input" placeholder="e.g. 01855621000">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Account Type</label>
                                <select name="nagad_type" class="admin-input">
                                    <option value="Merchant" {{ ($settings['nagad_type'] ?? 'Merchant') == 'Merchant' ? 'selected' : '' }}>Merchant (Payment)</option>
                                    <option value="Personal" {{ ($settings['nagad_type'] ?? '') == 'Personal' ? 'selected' : '' }}>Personal (Send Money)</option>
                                </select>
                            </div>
                            <div class="admin-form-group" style="margin: 0; grid-column: 1 / -1;">
                                <label class="admin-label">Nagad Payment Instructions</label>
                                <textarea name="nagad_instructions" rows="2" class="admin-input" placeholder="Instructions shown to passenger...">{{ $settings['nagad_instructions'] ?? 'Dial *167# → Send Money to the number above → Enter TrxID to confirm.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. ROCKET --}}
                <div style="border: 1.5px solid #e9d5ff; border-radius: 14px; overflow: hidden;">
                    <div style="background: #faf5ff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="padding: 4px 10px; background: #8c3494; color: #fff; border-radius: 8px; font-weight: 900; font-size: 13px;">Rocket</div>
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #581c87;">DBBL Rocket</div>
                                <div style="font-size: 11.5px; color: #7e22ce;">Dutch-Bangla Bank mobile wallet</div>
                            </div>
                        </div>
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; font-weight: 700; color: #581c87; background: #fff; padding: 6px 14px; border-radius: 30px; border: 1px solid #d8b4fe;">
                            <input type="checkbox" name="rocket_active" value="1" {{ setting('rocket_active', '0') == '1' ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: #8c3494; cursor: pointer;">
                            <span>Enable Rocket</span>
                        </label>
                    </div>
                    <div style="padding: 18px 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Rocket Account Number (with Check Digit)</label>
                                <input name="rocket_number" type="text" value="{{ $settings['rocket_number'] ?? '019855621008' }}" class="admin-input" placeholder="e.g. 019855621008">
                            </div>
                            <div class="admin-form-group" style="margin: 0;">
                                <label class="admin-label">Account Type</label>
                                <select name="rocket_type" class="admin-input">
                                    <option value="Merchant" {{ ($settings['rocket_type'] ?? 'Merchant') == 'Merchant' ? 'selected' : '' }}>Merchant</option>
                                    <option value="Personal" {{ ($settings['rocket_type'] ?? '') == 'Personal' ? 'selected' : '' }}>Personal</option>
                                </select>
                            </div>
                            <div class="admin-form-group" style="margin: 0; grid-column: 1 / -1;">
                                <label class="admin-label">Rocket Payment Instructions</label>
                                <textarea name="rocket_instructions" rows="2" class="admin-input" placeholder="Instructions shown to passenger...">{{ $settings['rocket_instructions'] ?? 'Dial *322# → Send Money to the number above → Enter TrxID to confirm.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── SECTION 3: GENERAL BRANDING & CONTACT ─── --}}
        <div class="admin-form-card" style="margin-bottom: 28px; border-radius: 16px; border: 1px solid var(--border);">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-globe"></i>
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">General Branding & Contact Info</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin: 0;">Brand name, text logo, helpline, contact emails, and office address</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Full Website Name</label>
                    <input name="site_name" type="text" value="{{ $settings['site_name'] ?? 'SwiftBus' }}" class="admin-input" placeholder="e.g. SwiftBus">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">24/7 Helpline Number</label>
                    <input name="helpline" type="text" value="{{ $settings['helpline'] ?? '16374' }}" class="admin-input" placeholder="e.g. 16374">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Text Logo Prefix (White Part)</label>
                    <input name="site_logo_prefix" type="text" value="{{ $settings['site_logo_prefix'] ?? 'Swift' }}" class="admin-input" placeholder="e.g. Swift">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Text Logo Suffix (Accent Part)</label>
                    <input name="site_logo_suffix" type="text" value="{{ $settings['site_logo_suffix'] ?? 'Bus' }}" class="admin-input" placeholder="e.g. Bus">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Primary Contact Phone</label>
                    <input name="contact_phone" type="text" value="{{ $settings['contact_phone'] ?? '01715484510' }}" class="admin-input" placeholder="e.g. 01715484510">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Official Support Email</label>
                    <input name="contact_email" type="email" value="{{ $settings['contact_email'] ?? 'info@xyz.net' }}" class="admin-input" placeholder="e.g. info@xyz.net">
                </div>
                <div class="admin-form-group" style="grid-column: 1 / -1;">
                    <label class="admin-label">Office Physical Address</label>
                    <textarea name="contact_address" rows="2" class="admin-input" placeholder="e.g. Road-8, House-14, Sector-6, Uttara, Dhaka">{{ $settings['contact_address'] ?? "Road-8, House-14, Sector-6\nUttara, Dhaka-1230" }}</textarea>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Facebook URL</label>
                    <input name="facebook_url" type="text" value="{{ $settings['facebook_url'] ?? '' }}" class="admin-input" placeholder="https://facebook.com/yourpage">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Footer Copyright Text</label>
                    <input name="footer_copyright" type="text" value="{{ $settings['footer_copyright'] ?? '© 2026 SwiftBus. All rights reserved.' }}" class="admin-input" placeholder="© 2026 SwiftBus...">
                </div>
            </div>
        </div>

        {{-- ─── SUBMIT BUTTON ─── --}}
        <div style="display: flex; justify-content: flex-end; gap: 14px; padding-bottom: 40px;">
            <button type="submit" class="btn-primary-admin" style="padding: 14px 36px; font-size: 15px; font-weight: 800; border-radius: 12px; box-shadow: 0 4px 18px rgba(59, 130, 246, 0.35);">
                <i class="fas fa-save" style="margin-right: 8px;"></i> Save All Settings
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var target = document.getElementById(previewId);
            if (target.tagName.toLowerCase() === 'img') {
                target.src = e.target.result;
            } else {
                target.innerHTML = '<img src="' + e.target.result + '" style="max-height:80px; max-width:90%; object-fit:contain;">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
