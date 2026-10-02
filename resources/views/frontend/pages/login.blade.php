<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In – {{ setting('site_name', 'SwiftBus') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <a class="auth-brand" href="{{ route('frontend.home') }}">
                <div class="auth-brand-icon"><i class="fas fa-bus-simple"></i></div>
                <span>{{ setting('site_name', 'SwiftBus') }}</span>
            </a>
        </div>

        <div class="auth-card">
            <div class="auth-form-box">
                <h1>Sign In</h1>
                <p class="subtitle">Enter your details to manage your bookings</p>

                @if(session()->has('message'))
                    <div style="background: rgba(46, 125, 50, 0.16); border: 1px solid rgba(76, 175, 80, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 13.5px; color: #a2e043;">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.16); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 13.5px; color: #fca5a5;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('user.do.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="form-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
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
                        <a href="{{ route('user.emailforget') }}" style="font-size:13px; color:#8fa08e; text-decoration:none; transition: color 0.15s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#8fa08e'">Forgot password?</a>
                    </div>
                    <button type="submit" class="submit-btn">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right" style="font-size: 13px;"></i>
                    </button>
                </form>

                <p class="auth-link">Don't have an account? <a href="{{ route('user.registration') }}">Create one</a></p>
            </div>
        </div>

        <div class="auth-footer">© {{ date('Y') }} {{ setting('site_name', 'SwiftBus') }}. All rights reserved.</div>
    </div>
</body>
</html>
