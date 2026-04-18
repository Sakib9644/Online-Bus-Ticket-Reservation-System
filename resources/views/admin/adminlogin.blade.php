<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login – SwiftBus</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: #0d0d0d;
            display: flex; align-items: center; justify-content: center;
            font-family: 'DM Sans', sans-serif;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,77,28,0.1) 0%, transparent 70%);
            top: -100px; right: -100px;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,51,255,0.06) 0%, transparent 70%);
            bottom: -80px; left: -80px;
        }

        .login-box {
            width: 100%; max-width: 420px;
            background: #111;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 48px;
            position: relative; z-index: 1;
        }
        .admin-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #1a1a1a; border: 1px solid #2a2a2a;
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #555;
            margin-bottom: 28px;
        }
        .admin-badge .dot { width: 6px; height: 6px; background: #ff4d1c; border-radius: 50%; }
        h1 { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 32px; color: #fff; margin-bottom: 8px; }
        .subtitle { color: #444; font-size: 14px; margin-bottom: 36px; }

        .form-label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #444; margin-bottom: 8px; }
        .form-field { position: relative; margin-bottom: 16px; }
        .form-field i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #333; font-size: 14px; }
        .form-field input {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            padding: 13px 14px 13px 42px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: border-color .2s;
        }
        .form-field input:focus { border-color: #ff4d1c; }
        .form-field input::placeholder { color: #2e2e2e; }

        .submit-btn {
            width: 100%; margin-top: 8px;
            background: #ff4d1c; color: #fff; border: none;
            border-radius: 10px; padding: 14px;
            font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
            cursor: pointer; transition: background .2s, transform .15s;
        }
        .submit-btn:hover { background: #e03a0e; transform: translateY(-1px); }

        .error-box { background: #1e0a0a; border: 1px solid #3a1010; border-radius: 10px; padding: 12px 16px; color: #ff6b6b; font-size: 13px; margin-bottom: 20px; }

        .back-link { display: block; text-align: center; margin-top: 24px; color: #333; font-size: 13px; text-decoration: none; transition: color .15s; }
        .back-link:hover { color: #666; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="admin-badge"><div class="dot"></div> Admin Access</div>
        <h1>Admin Login</h1>
        <p class="subtitle">SwiftBus control panel</p>

        @if($errors->any())
        <div class="error-box">
            <i class="fas fa-triangle-exclamation" style="margin-right:8px;"></i>{{ $errors->first() }}
        </div>
        @endif

        @if(session('error'))
        <div class="error-box">
            <i class="fas fa-triangle-exclamation" style="margin-right:8px;"></i>{{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.doLogin') }}" method="POST">
            @csrf
            <label class="form-label">Email Address</label>
            <div class="form-field">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="admin@swiftbus.com" required>
            </div>
            <label class="form-label">Password</label>
            <div class="form-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="submit-btn">Access Dashboard →</button>
        </form>

        <a class="back-link" href="{{ route('frontend.home') }}">← Back to website</a>
    </div>
</body>
</html>
