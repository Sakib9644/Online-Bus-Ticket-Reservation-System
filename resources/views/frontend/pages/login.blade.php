<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login – SwiftBus</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            font-family: 'DM Sans', sans-serif;
            background: #121611;
            color: #ffffff;
        }

        /* LEFT PANEL */
        .auth-left {
            background: #1c201b;
            display: flex; flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.12);
        }
        .auth-left::before {
            content: '';
            position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(162,224,67,0.15) 0%, transparent 70%);
        }
        .auth-brand {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 20px;
            color: #fff; text-decoration: none;
        }
        .auth-brand-icon {
            width: 36px; height: 36px; background: #a2e043;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            color: #0d1a09; font-size: 16px;
        }
        .auth-left-content { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 60px 0; }
        .auth-left-content h2 {
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: clamp(32px, 4vw, 52px);
            color: #fff; line-height: 1.1; margin-bottom: 20px;
        }
        .auth-left-content h2 span { color: #a2e043; }
        .auth-left-content p { color: #8a9688; font-size: 15px; max-width: 340px; }

        .feature-list { margin-top: 40px; display: flex; flex-direction: column; gap: 16px; }
        .feature-item { display: flex; align-items: center; gap: 12px; }
        .feature-dot { width: 8px; height: 8px; background: #a2e043; border-radius: 50%; flex-shrink: 0; }
        .feature-item span { color: #8a9688; font-size: 14px; margin-top: 2px;}

        .auth-left-footer { color: #8a9688; font-size: 12px; }

        /* RIGHT PANEL */
        .auth-right {
            display: flex; flex-direction: column; justify-content: center;
            align-items: center;
            padding: 48px;
        }
        .auth-form-box { width: 100%; max-width: 380px; }
        .auth-form-box h1 {
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: 28px; margin-bottom: 8px; color: #fff;
        }
        .auth-form-box .subtitle { color: #8a9688; font-size: 14px; margin-bottom: 36px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #8a9688; margin-bottom: 8px; }
        .form-field {
            position: relative;
        }
        .form-field i {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #8a9688; font-size: 14px;
        }
        .form-field input {
            width: 100%;
            background: #1c201b;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 13px 14px 13px 40px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #ffffff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-field input:focus {
            border-color: #a2e043;
            box-shadow: 0 0 0 3px rgba(162,224,67,0.15);
        }
        .form-field input::placeholder { color: #555; }

        .submit-btn {
            width: 100%;
            background: #a2e043;
            color: #0d1a09;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 8px;
            transition: background .2s, transform .15s;
        }
        .submit-btn:hover { background: #8dc63f; transform: translateY(-1px); }

        .auth-divider { text-align: center; color: #8a9688; font-size: 13px; margin: 20px 0; position: relative; }
        .auth-divider::before, .auth-divider::after {
            content: ''; position: absolute; top: 50%; width: 42%;
            height: 1px; background: rgba(255, 255, 255, 0.12);
        }
        .auth-divider::before { left: 0; } .auth-divider::after { right: 0; }

        .auth-link { text-align: center; font-size: 14px; color: #8a9688; margin-top: 24px; }
        .auth-link a { color: #a2e043; text-decoration: none; font-weight: 600; }
        .auth-link a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .auth-left { display: none; }
        }
    </style>
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
