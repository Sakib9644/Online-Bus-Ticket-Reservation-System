<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register – SwiftBus</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; font-family: 'DM Sans', sans-serif; background: #faf9f6; }
        .auth-left { background: #0d0d0d; display: flex; flex-direction: column; justify-content: space-between; padding: 48px; position: relative; overflow: hidden; }
        .auth-left::before { content: ''; position: absolute; bottom: -80px; right: -80px; width: 360px; height: 360px; border-radius: 50%; background: radial-gradient(circle, rgba(0,51,255,0.12) 0%, transparent 70%); }
        .auth-brand { display: flex; align-items: center; gap: 10px; font-family: 'Syne', sans-serif; font-weight: 800; font-size: 20px; color: #fff; text-decoration: none; }
        .auth-brand-icon { width: 36px; height: 36px; background: #ff4d1c; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; }
        .auth-left-content { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 60px 0; }
        .auth-left-content h2 { font-family: 'Syne', sans-serif; font-weight: 800; font-size: clamp(30px,4vw,48px); color: #fff; line-height: 1.1; margin-bottom: 20px; }
        .auth-left-content h2 span { color: #ff4d1c; }
        .auth-left-content p { color: #666; font-size: 15px; }
        .step-list { margin-top: 40px; display: flex; flex-direction: column; gap: 0; }
        .step-item { display: flex; gap: 16px; padding-bottom: 24px; position: relative; }
        .step-item:not(:last-child)::after { content:''; position:absolute; left:15px; top:32px; bottom:0; width:1px; background:#1e1e1e; }
        .step-num { width: 32px; height: 32px; border-radius: 50%; background: #1a1a1a; border: 1px solid #2a2a2a; display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: #888; flex-shrink: 0; }
        .step-item.active .step-num { background: #ff4d1c; border-color: #ff4d1c; color: #fff; }
        .step-text { color: #555; font-size: 14px; padding-top: 6px; }
        .step-item.active .step-text { color: #fff; }
        .auth-left-footer { color: #333; font-size: 12px; }
        .auth-right { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 48px; overflow-y: auto; }
        .auth-form-box { width: 100%; max-width: 420px; }
        .auth-form-box h1 { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 28px; margin-bottom: 8px; color: #0d0d0d; }
        .auth-form-box .subtitle { color: #888; font-size: 14px; margin-bottom: 36px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1/-1; }
        .form-label { display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px; }
        .form-field { position: relative; }
        .form-field i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 14px; }
        .form-field input { width: 100%; background: #fff; border: 1px solid #e8e4de; border-radius: 10px; padding: 13px 14px 13px 40px; font-family: 'DM Sans', sans-serif; font-size: 14px; color: #0d0d0d; outline: none; transition: border-color .2s, box-shadow .2s; }
        .form-field input:focus { border-color: #0d0d0d; box-shadow: 0 0 0 3px rgba(13,13,13,0.06); }
        .form-field input::placeholder { color: #bbb; }
        .submit-btn { width: 100%; background: #ff4d1c; color: #fff; border: none; border-radius: 10px; padding: 14px; font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 8px; transition: background .2s, transform .15s; }
        .submit-btn:hover { background: #e03a0e; transform: translateY(-1px); }
        .auth-link { text-align: center; font-size: 14px; color: #888; margin-top: 24px; }
        .auth-link a { color: #ff4d1c; text-decoration: none; font-weight: 500; }
        @media (max-width: 768px) { body { grid-template-columns: 1fr; } .auth-left { display: none; } }
    </style>
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
