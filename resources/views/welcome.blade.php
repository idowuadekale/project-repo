<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LASU CS — Final Year Project Repository</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Inter:wght@400;500;600&display=swap"
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
            --navy: #0F172A;
            --navy2: #1E293B;
            --blue: #2563EB;
            --blue2: #3B82F6;
            --gold: #F59E0B;
            --white: #F8FAFC;
            --muted: #94A3B8;
            --border: rgba(255, 255, 255, 0.08);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: background 0.3s;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-logo {
            width: 36px;
            height: 36px;
            background: var(--blue);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 16px;
            color: #fff;
        }

        .nav-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 15px;
        }

        .nav-sub {
            font-size: 11px;
            color: var(--muted);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-ghost {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--white);
            text-decoration: none;
            border: 1px solid transparent;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-ghost:hover {
            border-color: var(--border);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            background: var(--blue);
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            border: none;
        }

        .btn-primary:hover {
            background: var(--blue2);
            transform: translateY(-1px);
        }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 2rem 4rem;
        }

        /* Grid background */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(37, 99, 235, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, black 40%, transparent 100%);
        }

        /* Glowing orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
            pointer-events: none;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: var(--blue);
            top: -100px;
            right: -100px;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: #7C3AED;
            bottom: -50px;
            left: -80px;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: var(--gold);
            top: 40%;
            right: 15%;
            opacity: 0.12;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            max-width: 1100px;
            width: 100%;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37, 99, 235, 0.15);
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 500;
            color: #93C5FD;
            margin-bottom: 1.25rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .eyebrow-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3B82F6;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.8);
            }
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.4rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }

        .hero-title .accent {
            background: linear-gradient(135deg, #60A5FA, #A78BFA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 17px;
            line-height: 1.7;
            color: #94A3B8;
            margin-bottom: 2rem;
            max-width: 480px;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 26px;
            border-radius: 10px;
            background: var(--blue);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }

        .btn-cta-primary:hover {
            background: var(--blue2);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-cta-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 26px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #CBD5E1;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cta-secondary:hover {
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .stat-item {}

        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── 3D Document Stack ── */
        .hero-visual {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .scene {
            width: 320px;
            height: 360px;
            perspective: 900px;
            position: relative;
        }

        .doc-stack {
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            animation: float-stack 6s ease-in-out infinite;
            position: relative;
        }

        @keyframes float-stack {

            0%,
            100% {
                transform: rotateX(12deg) rotateY(-18deg) translateY(0);
            }

            50% {
                transform: rotateX(10deg) rotateY(-16deg) translateY(-14px);
            }
        }

        .doc-card {
            position: absolute;
            width: 240px;
            border-radius: 12px;
            padding: 20px;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        .doc-card-1 {
            background: linear-gradient(135deg, #1E3A5F, #1e40af);
            border: 1px solid rgba(96, 165, 250, 0.25);
            top: 20px;
            left: 40px;
            transform: translateZ(60px) rotateY(0deg);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        .doc-card-2 {
            background: linear-gradient(135deg, #1a2744, #1e3a8a);
            border: 1px solid rgba(96, 165, 250, 0.15);
            top: 60px;
            left: 20px;
            transform: translateZ(30px) rotateY(2deg) rotateZ(-2deg);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .doc-card-3 {
            background: linear-gradient(135deg, #161e30, #172554);
            border: 1px solid rgba(96, 165, 250, 0.1);
            top: 100px;
            left: 5px;
            transform: translateZ(0px) rotateY(3deg) rotateZ(-4deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .doc-bar {
            height: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .doc-bar-1 {
            background: #60A5FA;
            width: 65%;
        }

        .doc-bar-2 {
            background: rgba(96, 165, 250, 0.35);
            width: 90%;
        }

        .doc-bar-3 {
            background: rgba(96, 165, 250, 0.2);
            width: 75%;
        }

        .doc-bar-4 {
            background: rgba(96, 165, 250, 0.15);
            width: 55%;
        }

        .doc-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: rgba(34, 197, 94, 0.2);
            color: #86EFAC;
            border: 1px solid rgba(34, 197, 94, 0.25);
            margin-bottom: 14px;
        }

        /* Floating mini badges */
        .float-badge {
            position: absolute;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(8px);
            animation: float-badge 4s ease-in-out infinite;
            white-space: nowrap;
            z-index: 10;
        }

        .float-badge-1 {
            top: 10px;
            right: 0px;
            animation-delay: 0s;
        }

        .float-badge-2 {
            bottom: 60px;
            right: -10px;
            animation-delay: 1.5s;
        }

        .float-badge-3 {
            bottom: 10px;
            left: 20px;
            animation-delay: 0.8s;
        }

        @keyframes float-badge {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .dot-green {
            background: #22C55E;
            box-shadow: 0 0 6px #22C55E;
        }

        .dot-blue {
            background: #60A5FA;
            box-shadow: 0 0 6px #60A5FA;
        }

        .dot-amber {
            background: #F59E0B;
            box-shadow: 0 0 6px #F59E0B;
        }

        /* ── Section divider ── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.07), transparent);
        }

        /* ── Roles section ── */
        .section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        .section-label {
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #3B82F6;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            font-size: 16px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.7;
        }

        /* Role cards */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s, border-color 0.3s, background 0.3s;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .role-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.05);
        }

        .role-card:hover::before {
            opacity: 1;
        }

        .role-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 1.2rem;
        }

        .role-icon-blue {
            background: rgba(37, 99, 235, 0.2);
        }

        .role-icon-purple {
            background: rgba(124, 58, 237, 0.2);
        }

        .role-icon-amber {
            background: rgba(245, 158, 11, 0.2);
        }

        .role-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 0.75rem;
        }

        .tag-blue {
            background: rgba(37, 99, 235, 0.15);
            color: #93C5FD;
            border: 1px solid rgba(37, 99, 235, 0.25);
        }

        .tag-purple {
            background: rgba(124, 58, 237, 0.15);
            color: #C4B5FD;
            border: 1px solid rgba(124, 58, 237, 0.25);
        }

        .tag-amber {
            background: rgba(245, 158, 11, 0.15);
            color: #FCD34D;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .role-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }

        .role-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }

        .role-permissions {
            list-style: none;
        }

        .role-permissions li {
            font-size: 13px;
            color: #CBD5E1;
            padding: 5px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-permissions li:last-child {
            border-bottom: none;
        }

        .perm-check {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #86EFAC;
            flex-shrink: 0;
        }

        /* ── How it works ── */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 3rem;
            position: relative;
        }

        .step-connector {
            position: absolute;
            top: 28px;
            left: calc(12.5% + 20px);
            right: calc(12.5% + 20px);
            height: 1px;
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.4), rgba(37, 99, 235, 0.1));
            z-index: 0;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
            position: relative;
            z-index: 1;
            transition: transform 0.3s, border-color 0.3s;
        }

        .step-card:hover {
            transform: translateY(-3px);
            border-color: rgba(37, 99, 235, 0.3);
        }

        .step-num {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.15);
            border: 1px solid rgba(37, 99, 235, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 14px;
            color: #60A5FA;
            margin: 0 auto 1rem;
            position: relative;
        }

        .step-num::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 1px solid rgba(37, 99, 235, 0.15);
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .step-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── Features grid ── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            overflow: hidden;
            margin-top: 3rem;
        }

        .feat-cell {
            background: var(--navy);
            padding: 2rem;
            transition: background 0.2s;
        }

        .feat-cell:hover {
            background: rgba(37, 99, 235, 0.06);
        }

        .feat-emoji {
            font-size: 28px;
            margin-bottom: 1rem;
            display: block;
        }

        .feat-title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 0.4rem;
        }

        .feat-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── CTA Banner ── */
        .cta-banner {
            background: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 50%, #1D4ED8 100%);
            border-top: 1px solid rgba(96, 165, 250, 0.2);
            border-bottom: 1px solid rgba(96, 165, 250, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .cta-inner {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
            padding: 5rem 2rem;
            text-align: center;
        }

        .cta-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-desc {
            font-size: 16px;
            color: #BFDBFE;
            margin-bottom: 2rem;
        }

        .btn-cta-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 10px;
            background: #fff;
            color: #1D4ED8;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cta-white:hover {
            background: #EFF6FF;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        }

        /* ── Footer ── */
        .footer {
            background: #080E1A;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #60A5FA;
            margin-bottom: 0.4rem;
        }

        .footer-text {
            font-size: 13px;
            color: #475569;
        }

        .footer-dev {
            font-size: 12px;
            color: #334155;
            margin-top: 0.4rem;
        }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .hero-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-visual {
                display: none;
            }

            .hero-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-cta {
                justify-content: center;
            }

            .hero-stats {
                justify-content: center;
            }

            .roles-grid {
                grid-template-columns: 1fr;
            }

            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .step-connector {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 0.9rem 1rem;
            }

            .section {
                padding: 3.5rem 1rem;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 5rem 1rem 3rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .doc-stack,
            .float-badge,
            .eyebrow-dot {
                animation: none;
            }
        }
    </style>
</head>

<body>

    {{-- ── Navbar ── --}}
    <nav class="navbar">
        <div class="nav-brand">
            <div class="nav-logo">P</div>
            <div>
                <div class="nav-title">LASU Project Repo</div>
                <div class="nav-sub">Faculty of Science, Ojo</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="{{ route('login') }}" class="btn-ghost">Login</a>
            <a href="{{ route('register') }}" class="btn-primary">Register</a>
        </div>
    </nav>

    {{-- ── Hero ── --}}
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="hero-inner">
            {{-- Left column --}}
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Lagos State University, Ojo
                </div>
                <h1 class="hero-title">
                    The Departmental<br>
                    <span class="accent">Project Repository</span><br>
                    for Science
                </h1>
                <p class="hero-desc">
                    A secure, searchable digital archive for final year projects.
                    Submit, review, and access approved research — all in one place.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('register') }}" class="btn-cta-primary">
                        Get Started &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="btn-cta-secondary">
                        Login to Browse
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-num">7+</div>
                        <div class="stat-label">Departments</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">3</div>
                        <div class="stat-label">User Roles</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">100%</div>
                        <div class="stat-label">Secure Storage</div>
                    </div>
                </div>
            </div>

            {{-- Right column — 3D visual --}}
            <div class="hero-visual">
                <div class="scene" id="scene">
                    <div class="doc-stack" id="docStack">

                        {{-- Back card --}}
                        <div class="doc-card doc-card-3">
                            <div class="doc-bar doc-bar-2"></div>
                            <div class="doc-bar doc-bar-3"></div>
                            <div class="doc-bar doc-bar-4"></div>
                            <div class="doc-bar doc-bar-3"></div>
                        </div>

                        {{-- Middle card --}}
                        <div class="doc-card doc-card-2">
                            <div class="doc-bar doc-bar-1" style="width:55%;"></div>
                            <div class="doc-bar doc-bar-2"></div>
                            <div class="doc-bar doc-bar-3" style="width:80%;"></div>
                            <div class="doc-bar doc-bar-4"></div>
                            <div class="doc-bar doc-bar-2" style="width:60%;"></div>
                        </div>

                        {{-- Front card --}}
                        <div class="doc-card doc-card-1">
                            <div class="doc-badge">✓ Approved</div>
                            <div class="doc-bar doc-bar-1"></div>
                            <div class="doc-bar doc-bar-2"></div>
                            <div class="doc-bar doc-bar-1" style="width:50%;"></div>
                            <div class="doc-bar doc-bar-3"></div>
                            <div class="doc-bar doc-bar-2" style="width:80%;"></div>
                            <div style="margin-top:14px; display:flex; gap:8px; align-items:center;">
                                <div
                                    style="width:28px;height:28px;border-radius:50%;background:rgba(96,165,250,0.2);display:flex;align-items:center;justify-content:center;font-size:11px;color:#93C5FD;font-weight:700;">
                                    CS</div>
                                <div>
                                    <div
                                        style="height:7px;width:90px;background:rgba(96,165,250,0.3);border-radius:4px;margin-bottom:4px;">
                                    </div>
                                    <div
                                        style="height:6px;width:60px;background:rgba(96,165,250,0.15);border-radius:4px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="float-badge float-badge-1">
                    <span class="badge-dot dot-green"></span>
                    Project Approved
                </div>
                <div class="float-badge float-badge-2">
                    <span class="badge-dot dot-blue"></span>
                    PDF Uploaded
                </div>
                <div class="float-badge float-badge-3">
                    <span class="badge-dot dot-amber"></span>
                    Under Review
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    {{-- ── Roles section ── --}}
    <div style="background: rgba(0,0,0,0.2);">
        <div class="section">
            <div class="reveal">
                <div class="section-label">Who it's for</div>
                <h2 class="section-title">Built for everyone<br>in the process</h2>
                <p class="section-desc">Three distinct portals — each designed around the exact tasks that role needs to
                    perform.</p>
            </div>

            <div class="roles-grid">
                <div class="role-card reveal reveal-delay-1">
                    <div class="role-icon role-icon-blue">🎓</div>
                    <span class="role-tag tag-blue">Student</span>
                    <div class="role-name">Submit & Track</div>
                    <div class="role-desc">Upload your final year project and monitor its review status in real time.
                    </div>
                    <ul class="role-permissions">
                        <li><span class="perm-check">✓</span> Submit project with PDF</li>
                        <li><span class="perm-check">✓</span> Track approval status</li>
                        <li><span class="perm-check">✓</span> Read supervisor feedback</li>
                        <li><span class="perm-check">✓</span> Browse approved repository</li>
                    </ul>
                </div>

                <div class="role-card reveal reveal-delay-2">
                    <div class="role-icon role-icon-purple">🔬</div>
                    <span class="role-tag tag-purple">Supervisor</span>
                    <div class="role-name">Review & Approve</div>
                    <div class="role-desc">Manage your assigned submissions and provide structured feedback to
                        students.</div>
                    <ul class="role-permissions">
                        <li><span class="perm-check">✓</span> View assigned projects</li>
                        <li><span class="perm-check">✓</span> Approve or reject submissions</li>
                        <li><span class="perm-check">✓</span> Leave written comments</li>
                        <li><span class="perm-check">✓</span> Download project PDFs</li>
                    </ul>
                </div>

                <div class="role-card reveal reveal-delay-3">
                    <div class="role-icon role-icon-amber">⚙️</div>
                    <span class="role-tag tag-amber">Administrator</span>
                    <div class="role-name">Manage & Report</div>
                    <div class="role-desc">Full system oversight — users, projects, statistics and complete audit
                        trails.</div>
                    <ul class="role-permissions">
                        <li><span class="perm-check">✓</span> Manage all users</li>
                        <li><span class="perm-check">✓</span> Override review decisions</li>
                        <li><span class="perm-check">✓</span> Generate dept. reports</li>
                        <li><span class="perm-check">✓</span> View activity logs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- ── How it works ── --}}
    <div class="section">
        <div class="reveal">
            <div class="section-label">The workflow</div>
            <h2 class="section-title">From submission<br>to archive in 4 steps</h2>
        </div>

        <div class="steps-grid">
            <div class="step-connector"></div>
            @foreach ([['01', 'Register', 'Create your account as a student or supervisor and select your department.'], ['02', 'Submit', 'Fill the submission form, upload your PDF, and assign your supervisor.'], ['03', 'Review', 'Your supervisor reads your work and approves, rejects, or leaves comments.'], ['04', 'Archive', 'Approved projects are published to the searchable repository.']] as [$n, $t, $d])
                <div class="step-card reveal reveal-delay-{{ $loop->index + 1 }}">
                    <div class="step-num">{{ $n }}</div>
                    <div class="step-title">{{ $t }}</div>
                    <div class="step-desc">{{ $d }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="divider"></div>

    {{-- ── Features ── --}}
    <div style="background: rgba(0,0,0,0.15);">
        <div class="section">
            <div class="reveal">
                <div class="section-label">Features</div>
                <h2 class="section-title">Everything in one place</h2>
            </div>

            <div class="features-grid reveal">
                @foreach ([['📁', 'Secure PDF Storage', 'Project files live in a private store — never publicly accessible via URL.'], ['🔍', 'Full-Text Search', 'Search approved projects by title, abstract, or keyword instantly.'], ['🔒', 'Role-Based Access', 'Each user sees exactly what they need — nothing more, nothing less.'], ['💬', 'Supervisor Comments', 'Structured feedback system between students and their supervisors.'], ['📊', 'Dept. Reports', 'Year-by-year and department-by-department project statistics for admins.'], ['📋', 'Activity Audit Log', 'Every action is logged with user, timestamp and IP for accountability.']] as [$emoji, $title, $desc])
                    <div class="feat-cell">
                        <span class="feat-emoji">{{ $emoji }}</span>
                        <div class="feat-title">{{ $title }}</div>
                        <div class="feat-desc">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── CTA Banner ── --}}
    <div class="cta-banner">
        <div class="cta-inner reveal">
            <h2 class="cta-title">Ready to submit your project?</h2>
            <p class="cta-desc">Register with your department details to get started. It takes less than a minute.</p>
            <a href="{{ route('register') }}" class="btn-cta-white">
                Create Your Account &rarr;
            </a>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <footer class="footer">
        <div class="footer-logo">LASU Project Repository</div>
        <div class="footer-text">&copy; {{ date('Y') }} Lagos State University, Ojo — Department of Computer
            Science Education</div>
        <div class="footer-dev">Developed by Adepemeji Samuel Adetomiwa &bull; Final Year Project &bull; 2025</div>
    </footer>

    <script>
        (function() {
            // ── Scroll reveal ──
            const reveals = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.12
            });
            reveals.forEach(el => io.observe(el));

            // ── 3D Parallax on mouse move ──
            const stack = document.getElementById('docStack');
            if (stack) {
                document.addEventListener('mousemove', function(e) {
                    if (window.innerWidth < 900) return;
                    const cx = window.innerWidth / 2;
                    const cy = window.innerHeight / 2;
                    const dx = (e.clientX - cx) / cx;
                    const dy = (e.clientY - cy) / cy;
                    const rx = 12 + dy * -5;
                    const ry = -18 + dx * 8;
                    stack.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg)`;
                });
                document.addEventListener('mouseleave', function() {
                    stack.style.transform = '';
                    stack.style.transition = 'transform 0.8s ease';
                    setTimeout(() => stack.style.transition = '', 800);
                });
            }

            // ── Navbar scroll state ──
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                navbar.style.background = window.scrollY > 40 ?
                    'rgba(15,23,42,0.97)' :
                    'rgba(15,23,42,0.85)';
            });
        })();
    </script>

</body>

</html>
