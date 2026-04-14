<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login – SwiftBus</title>
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
            <h2>Welcome<br>back to<br><span>SwiftBus</span></h2>
            <p>Your journey continues. Sign in to manage your bookings.</p>
            <div class="feature-list">
                <div class="feature-item"><div class="feature-dot"></div><span>View your upcoming trips</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span>Manage your reservations</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span>Get e-tickets instantly</span></div>
            </div>
        </div>
        <div class="auth-left-footer">© 2024 SwiftBus</div>
    </div>

    <div class="auth-right">
        <div class="auth-form-box">
            <h1>Sign In</h1>
            <p class="subtitle">Enter your credentials to continue</p>

            @if($errors->any())
                <div style="background:#fff1f0; border:1px solid #ffd4ce; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; color:#c53030;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('user.do.login') }}" method="POST">
                @csrf
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
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div style="text-align:right; margin-bottom:20px;">
                    <a href="{{ route('user.emailforget') }}" style="font-size:13px; color:#888; text-decoration:none;">Forgot password?</a>
                </div>
                <button type="submit" class="submit-btn">Sign In →</button>
            </form>

            <p class="auth-link">Don't have an account? <a href="{{ route('user.registration') }}">Create one</a></p>
        </div>
    </div>
</body>
</html>
