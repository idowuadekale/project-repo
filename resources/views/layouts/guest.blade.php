<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LASU Project Repository') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #0B1D3A;
            --navy2: #112348;
            --gold: #C9A84C;
            --gold-lt: #E8C97A;
            --cream: #F9F6EF;
            --slate: #4A5568;
            --muted: #718096;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT: Navy 3D panel ─────────────────────────────── */
        .auth-side {
            background: linear-gradient(160deg, var(--navy) 0%, var(--navy2) 50%, #1a3a6e 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 48px;
            overflow: hidden;
        }

        .auth-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 70% 30%, rgba(201, 168, 76, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 40% 60% at 10% 90%, rgba(24, 95, 165, 0.18) 0%, transparent 60%);
        }

        .auth-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px);
            background-size: 56px 56px;
        }

        .auth-brand {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-crest {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--gold), #a8793a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 800;
            color: var(--white);
        }

        .auth-brand-title {
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
        }

        .auth-brand-sub {
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
            margin-top: 1px;
        }

        .auth-visual {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 900px;
        }

        .doc-scene {
            position: relative;
            width: 240px;
            height: 310px;
            transform-style: preserve-3d;
            animation: sceneRotate 14s ease-in-out infinite;
        }

        @keyframes sceneRotate {
            0% {
                transform: rotateX(10deg) rotateY(-16deg);
            }

            40% {
                transform: rotateX(7deg) rotateY(10deg);
            }

            70% {
                transform: rotateX(12deg) rotateY(20deg);
            }

            100% {
                transform: rotateX(10deg) rotateY(-16deg);
            }
        }

        .doc-card {
            position: absolute;
            width: 200px;
            height: 264px;
            border-radius: 12px;
            left: 20px;
            transform-style: preserve-3d;
            display: flex;
            flex-direction: column;
        }

        .doc-card-face {
            position: absolute;
            inset: 0;
            border-radius: 12px;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            padding: 22px;
        }

        .doc-c1 {
            background: rgba(14, 40, 80, 0.9);
            border: 1px solid rgba(201, 168, 76, 0.2);
            transform: translateZ(-40px) translateX(-18px) translateY(18px) rotateZ(-5deg);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .doc-c2 {
            background: rgba(18, 50, 100, 0.95);
            border: 1px solid rgba(201, 168, 76, 0.3);
            transform: translateZ(0px) translateX(-6px) translateY(7px) rotateZ(-2deg);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
        }

        .doc-c3 {
            background: rgba(22, 60, 120, 0.98);
            border: 1px solid rgba(201, 168, 76, 0.5);
            transform: translateZ(40px) rotateZ(0deg);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(201, 168, 76, 0.1);
        }

        .doc-header-bar {
            width: 100%;
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--gold), transparent);
            margin-bottom: 16px;
        }

        .doc-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: rgba(201, 168, 76, 0.15);
            border: 1px solid rgba(201, 168, 76, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .doc-icon svg {
            width: 18px;
            height: 18px;
            color: var(--gold);
        }

        .doc-title-line {
            height: 9px;
            border-radius: 5px;
            margin-bottom: 7px;
            background: rgba(255, 255, 255, 0.15);
        }

        .doc-title-line.w80 {
            width: 80%;
        }

        .doc-title-line.w60 {
            width: 60%;
            background: rgba(255, 255, 255, 0.1);
        }

        .doc-lines {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .doc-line {
            height: 5px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.08);
        }

        .doc-line.w95 {
            width: 95%;
        }

        .doc-line.w85 {
            width: 85%;
        }

        .doc-line.w70 {
            width: 70%;
        }

        .doc-line.w90 {
            width: 90%;
        }

        .doc-badge {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(201, 168, 76, 0.12);
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 100px;
            padding: 4px 11px;
            font-size: 10px;
            font-weight: 600;
            color: var(--gold);
            width: fit-content;
        }

        .doc-badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #22c55e;
        }

        .orbit-ring {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 1px dashed rgba(201, 168, 76, 0.15);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: spinRing 20s linear infinite;
        }

        @keyframes spinRing {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .orbit-dot {
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold);
            top: -3.5px;
            left: calc(50% - 3.5px);
            box-shadow: 0 0 8px var(--gold);
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0;
            animation: floatUp 6s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            width: 5px;
            height: 5px;
            top: 85%;
            left: 15%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 4px;
            height: 4px;
            top: 75%;
            left: 80%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 4px;
            height: 4px;
            top: 92%;
            left: 50%;
            animation-delay: 4s;
        }

        @keyframes floatUp {
            0% {
                opacity: 0;
                transform: translateY(0) scale(0.5);
            }

            20% {
                opacity: 0.6;
            }

            80% {
                opacity: 0.3;
            }

            100% {
                opacity: 0;
                transform: translateY(-110px) scale(1);
            }
        }

        .auth-quote {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            line-height: 1.7;
            border-left: 2px solid var(--gold);
            padding-left: 16px;
            margin-top: 24px;
        }

        .auth-quote strong {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
        }

        /* ── RIGHT: Form panel ───────────────────────────────── */
        .auth-form-panel {
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 400px;
        }

        .auth-mobile-brand {
            display: none;
            text-align: center;
            margin-bottom: 28px;
        }

        /* ── Back to home ───────────────────────────────────── */
        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            font-size: 13px;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.2s;
        }

        .auth-back:hover {
            color: var(--navy);
        }

        .auth-back svg {
            width: 14px;
            height: 14px;
        }

        @media (max-width: 900px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .auth-side {
                display: none;
            }

            .auth-mobile-brand {
                display: block;
            }

            .auth-form-panel {
                padding: 32px 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .doc-scene,
            .particle,
            .orbit-ring {
                animation: none;
            }
        }
    </style>
</head>

<body>

    <div class="auth-shell">

        {{-- LEFT: Navy 3D panel --}}
        <div class="auth-side">
            <div class="auth-brand">
                <div class="auth-crest">L</div>
                <div>
                    <div class="auth-brand-title">LASU Project Repository</div>
                    <div class="auth-brand-sub">Faculty of Science, Ojo</div>
                </div>
            </div>

            <div class="auth-visual">
                <div class="orbit-ring">
                    <div class="orbit-dot"></div>
                </div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>

                <div class="doc-scene">
                    <div class="doc-card doc-c1">
                        <div class="doc-card-face">
                            <div class="doc-header-bar"></div>
                            <div class="doc-lines">
                                <div class="doc-line w95"></div>
                                <div class="doc-line w85"></div>
                                <div class="doc-line w70"></div>
                            </div>
                        </div>
                    </div>
                    <div class="doc-card doc-c2">
                        <div class="doc-card-face">
                            <div class="doc-header-bar"></div>
                            <div class="doc-title-line w80"></div>
                            <div class="doc-title-line w60"></div>
                            <div class="doc-lines">
                                <div class="doc-line w95"></div>
                                <div class="doc-line w85"></div>
                                <div class="doc-line w90"></div>
                            </div>
                        </div>
                    </div>
                    <div class="doc-card doc-c3">
                        <div class="doc-card-face">
                            <div class="doc-header-bar"></div>
                            <div class="doc-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="doc-title-line w80"></div>
                            <div class="doc-title-line w60"></div>
                            <div class="doc-lines">
                                <div class="doc-line w95"></div>
                                <div class="doc-line w85"></div>
                                <div class="doc-line w90"></div>
                                <div class="doc-line w70"></div>
                            </div>
                            <div class="doc-badge"><span class="doc-badge-dot"></span>Approved</div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="auth-quote">
                <strong>"A permanent record of departmental research"</strong><br>
                Every approved project becomes part of a searchable archive accessible to students, supervisors, and
                staff for years to come.
            </p>
        </div>

        {{-- RIGHT: Form panel --}}
        <div class="auth-form-panel">
            <div class="auth-form-wrap">

                <div class="auth-mobile-brand">
                    <div class="auth-crest" style="margin: 0 auto 10px;">L</div>
                    <div style="font-weight:600; font-size:15px; color: var(--navy);">LASU Project Repository</div>
                </div>

                <a href="{{ url('/') }}" class="auth-back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5m7-7l-7 7 7 7" />
                    </svg>
                    Back to home
                </a>

                {{ $slot }}

            </div>
        </div>

    </div>

</body>

</html>
