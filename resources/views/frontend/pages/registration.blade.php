<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register – SwiftBus</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
</head>
<body>
    <div class="auth-left">
        <a class="auth-brand" href="{{ route('frontend.home') }}">
            <div class="auth-brand-icon"><i class="fas fa-bus-simple"></i></div>
            SwiftBus
        </a>
        <div class="auth-left-content">
            <h2>Join<br>Swift<span>Bus</span><br>today</h2>
            <p>Create your account in under a minute and start booking trips.</p>
            <div class="step-list">
                <div class="step-item active">
                    <div class="step-num">1</div>
                    <div class="step-text">Create your account</div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-text">Search available trips</div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text">Book & get your e-ticket</div>
                </div>
            </div>
        </div>
        <div class="auth-left-footer">© 2024 SwiftBus</div>
    </div>

    <div class="auth-right">
        <div class="auth-form-box">
            <h1>Create Account</h1>
            <p class="subtitle">Fill in your details to get started</p>

            @if($errors->any())
                <div style="background:#fff1f0; border:1px solid #ffd4ce; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; color:#c53030;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('user.registration.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="form-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Your full name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div class="form-field">
                        <i class="fas fa-phone"></i>
                        <input type="number" name="phone_no" placeholder="01XXXXXXXXX" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="form-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="you@example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="form-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Min. 8 characters" required>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Create My Account →</button>
            </form>

            <p class="auth-link">Already have an account? <a href="{{ route('user.login') }}">Sign in</a></p>
        </div>
    </div>
</body>
</html>
