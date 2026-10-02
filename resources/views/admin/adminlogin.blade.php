<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal Login – SwiftBus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --bg-dark: #0a0e17;
            --card-bg: #111827;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --border: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(59, 130, 246, 0.5);
            --text-muted: #94a3b8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: var(--bg-dark);
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow-x: hidden;
            padding: 24px;
        }

        /* Futuristic Background Gradients */
        body::before {
            content: '';
            position: absolute;
            width: 550px; 
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            top: -120px; 
            right: -100px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            width: 450px; 
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            bottom: -100px; 
            left: -100px;
            pointer-events: none;
        }

        .admin-login-wrapper {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 2;
        }

        .admin-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 30px rgba(59, 130, 246, 0.06);
            backdrop-filter: blur(20px);
        }

        /* Top Security Header */
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.25);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #60a5fa;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.35);
        }

        h1 {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 13.5px;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        /* Alerts */
        .error-banner {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fca5a5;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-banner {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: #6ee7b7;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 14px;
            transition: color 0.2s;
        }

        .input-field {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px 14px 44px;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
        }

        .input-field:focus {
            border-color: var(--accent);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
        }

        .input-field:focus + i {
            color: var(--accent);
        }

        .input-field::placeholder {
            color: #475569;
        }

        /* Options Row */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-label input {
            accent-color: var(--accent);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 18px rgba(59, 130, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.45);
        }

        /* Security Notice */
        .security-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12.5px;
        }

        .security-footer a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .security-footer a:hover {
            color: #93c5fd;
        }

        .ip-notice {
            font-size: 11px;
            color: #475569;
            text-align: center;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
    </style>
</head>
<body>

    <div class="admin-login-wrapper">
        <div class="admin-card">
            <div class="security-badge">
                <i class="fas fa-shield-halved"></i> Internal Operations Console
            </div>

            <div class="brand-header">
                <div class="brand-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div>
                    <h1>Administrator Login</h1>
                    <span style="font-size: 11px; color: #60a5fa; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">SwiftBus Central System</span>
                </div>
            </div>

            <p class="subtitle">Enter authenticated credentials to access transit operations, bookings, fleet, and system configurations.</p>

            @if(session()->has('message'))
                <div class="success-banner">
                    <i class="fas fa-circle-check"></i>
                    {{ session()->get('message') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-banner">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.doLogin') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Administrator Email</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="admin@swiftbus.com" required autofocus>
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Master Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" class="input-field" placeholder="••••••••••••" required>
                        <i class="fas fa-key"></i>
                    </div>
                </div>

                <div class="options-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Keep administrator session</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Authenticate & Enter Console <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="security-footer">
                <a href="{{ route('frontend.home') }}" title="Back to main site">
                    <i class="fas fa-arrow-left"></i> Public Website
                </a>
                <a href="{{ route('user.login') }}" title="Passenger ticket login">
                    <i class="fas fa-user"></i> Passenger Login
                </a>
            </div>
        </div>

        <div class="ip-notice">
            <i class="fas fa-lock" style="font-size: 10px;"></i>
            Protected administrative zone. Unauthorized access prohibited.
        </div>
    </div>

</body>
</html>
