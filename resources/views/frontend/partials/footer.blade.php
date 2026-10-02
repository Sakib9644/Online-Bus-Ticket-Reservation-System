<footer class="sb-footer" id="contact">
    <div class="contact-section" style="padding-bottom: 0;">
        <div style="text-align:center; margin-bottom: 48px;">
            <span class="sb-badge" style="background:#222; color:#888;">{{ setting('contact_badge', 'Get in touch') }}</span>
            <h2 class="syne" style="color:#fff; font-size:clamp(28px,4vw,44px); margin-top:16px;">{{ setting('contact_heading', "We're here to help") }}</h2>
            <p style="color:#666; margin-top:8px;">{{ setting('contact_subtitle', 'Have questions about your booking? Reach out anytime.') }}</p>
        </div>
        <div class="contact-grid">
            <div>
                <div class="contact-info-item">
                    <div class="contact-icon" style="background:rgba(141,198,63,0.1);"><i class="fas fa-phone" style="color:var(--accent);"></i></div>
                    <div>
                        <div class="contact-label">Phone</div>
                        <div class="contact-value" style="color:#fff;">
                            <a href="tel:{{ setting('contact_phone', '01715484510') }}" style="color:#fff; text-decoration:none;">{{ setting('contact_phone', '01715484510') }}</a>
                        </div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon" style="background:rgba(141,198,63,0.1);"><i class="fas fa-headset" style="color:var(--accent);"></i></div>
                    <div>
                        <div class="contact-label">Support Line</div>
                        <div class="contact-value" style="color:#fff;">
                            <a href="tel:{{ setting('contact_support_line', '01985562100') }}" style="color:#fff; text-decoration:none;">{{ setting('contact_support_line', '01985562100') }}</a>
                        </div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon" style="background:rgba(141,198,63,0.1);"><i class="fas fa-envelope" style="color:var(--accent);"></i></div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-value" style="color:#fff;">
                            <a href="mailto:{{ setting('contact_email', 'info@xyz.net') }}" style="color:#fff; text-decoration:none;">{{ setting('contact_email', 'info@xyz.net') }}</a>
                        </div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon" style="background:rgba(141,198,63,0.1);"><i class="fas fa-location-dot" style="color:var(--accent);"></i></div>
                    <div>
                        <div class="contact-label">Address</div>
                        <div class="contact-value" style="color:#fff;">
                            {!! nl2br(e(setting('contact_address', "Road-8, House-14, Sector-6\nSoftech Ltd, Dhaka-1230"))) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form action="" method="post" role="form" class="contactForm" style="background:#111; padding:32px; border-radius:16px; border:1px solid #1e1e1e;">
                    <h4 class="syne" style="color:#fff; margin-bottom:24px; font-size:18px;">Send us a message</h4>
                    <input type="text" name="name" class="sb-input" placeholder="Your Name" style="background:#1a1a1a; border-color:#2a2a2a; color:#fff;" />
                    <input type="email" name="email" class="sb-input" placeholder="Email Address" style="background:#1a1a1a; border-color:#2a2a2a; color:#fff;" />
                    <input type="text" name="subject" class="sb-input" placeholder="Subject" style="background:#1a1a1a; border-color:#2a2a2a; color:#fff;" />
                    <textarea name="message" rows="4" class="sb-input" placeholder="Your message..." style="background:#1a1a1a; border-color:#2a2a2a; color:#fff; resize:none;"></textarea>
                    <button type="submit" class="sb-btn sb-btn-accent" style="width:100%;">Send Message →</button>
                </form>
            </div>
        </div>
    </div>

    <div class="sb-footer-bottom" style="margin-top:60px; border-top:1px solid #1a1a1a; padding-top:28px; max-width:1100px; margin-left:auto; margin-right:auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <span>{{ setting('footer_copyright', '© ' . date('Y') . ' SwiftBus. All rights reserved.') }}</span>
        <div class="sb-social" style="display:flex; gap:10px;">
            @if(setting('facebook_url'))
                <a href="{{ setting('facebook_url') }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if(setting('twitter_url'))
                <a href="{{ setting('twitter_url') }}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
            @if(setting('instagram_url'))
                <a href="{{ setting('instagram_url') }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
        </div>
    </div>
</footer>
