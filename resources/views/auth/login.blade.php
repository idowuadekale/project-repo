<x-guest-layout>

    <style>
        .auth-h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 800;
            color: #0B1D3A;
            margin-bottom: 6px;
        }

        .auth-p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .field-group {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #0B1D3A;
            margin-bottom: 7px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            color: #A0AEC0;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            font-size: 14px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            color: #0B1D3A;
            background: #FAFBFC;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .field-input:focus {
            outline: none;
            border-color: #C9A84C;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
            background: #fff;
        }

        .field-error {
            color: #E24B4A;
            font-size: 12.5px;
            margin-top: 6px;
        }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .auth-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #4A5568;
            cursor: pointer;
        }

        .auth-check input {
            width: 16px;
            height: 16px;
            accent-color: #C9A84C;
            cursor: pointer;
        }

        .auth-forgot {
            font-size: 13px;
            color: #C9A84C;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-forgot:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: #0B1D3A;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 13px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-submit:hover {
            background: #112348;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 16px;
            height: 16px;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        .auth-divider span {
            font-size: 12px;
            color: #A0AEC0;
        }

        .auth-footer-link {
            text-align: center;
            font-size: 13.5px;
            color: #718096;
        }

        .auth-footer-link a {
            color: #C9A84C;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer-link a:hover {
            text-decoration: underline;
        }

        .status-banner {
            background: #ECFDF5;
            border: 1px solid #BBF7D0;
            color: #166534;
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>

    <h1 class="auth-h1">Welcome back</h1>
    <p class="auth-p">Sign in to access your dashboard</p>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="status-banner">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="field-group">
            <label class="field-label" for="email">Email address</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username" placeholder="you@lasu.edu.ng">
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="field-group">
            <label class="field-label" for="password">Password</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input id="password" class="field-input" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••">
            </div>
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-row">
            <label class="auth-check">
                <input type="checkbox" name="remember">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="auth-forgot" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            Sign in
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>

    <div class="auth-divider"><span>New to the repository</span></div>

    <p class="auth-footer-link">
        Don't have an account? <a href="{{ route('register') }}">Create one now</a>
    </p>

</x-guest-layout>
