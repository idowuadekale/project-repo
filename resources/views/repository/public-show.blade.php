<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }} — LASU Repository</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #0B1D3A;
            --navy2: #112348;
            --gold: #C9A84C;
            --cream: #F9F6EF;
            --muted: #718096;
            --white: #fff;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: var(--navy);
        }

        .pub-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(11, 29, 58, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.15);
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pub-nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .pub-nav-crest {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background: linear-gradient(135deg, var(--gold), #a8793a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 800;
            color: white;
        }

        .pub-nav-title {
            color: white;
            font-size: 13px;
            font-weight: 600;
        }

        .pub-nav-links {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .pub-nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
        }

        .pub-nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.08);
        }

        .pub-nav-btn {
            background: var(--gold);
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 6px;
            text-decoration: none;
        }

        .detail-wrap {
            max-width: 860px;
            margin: 0 auto;
            padding: 36px 1.5rem 64px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--muted);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--navy);
        }

        .breadcrumb-sep {
            color: #CBD5E0;
        }

        .detail-card {
            background: white;
            border: 1px solid #E8EDF2;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .detail-card-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 100%);
            padding: 28px 28px 24px;
        }

        .detail-approved {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ADE80;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 100px;
            margin-bottom: 14px;
        }

        .detail-approved-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4ADE80;
        }

        .detail-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(20px, 3vw, 28px);
            font-weight: 800;
            color: white;
            line-height: 1.3;
            margin-bottom: 14px;
        }

        .detail-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .detail-meta-item {
            color: rgba(255, 255, 255, 0.55);
            font-size: 13px;
        }

        .detail-meta-item strong {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .detail-body {
            padding: 28px;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .abstract-text {
            font-size: 14.5px;
            line-height: 1.8;
            color: #374151;
            background: #F8F9FB;
            padding: 20px;
            border-radius: 10px;
            border-left: 3px solid var(--gold);
        }

        .keywords-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }

        .kw-chip {
            background: #EFF6FF;
            color: #1E40AF;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: 100px;
            border: 1px solid #BFDBFE;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-top: 1px solid #F1F5F9;
        }

        .detail-field {
            padding: 16px 28px;
            border-bottom: 1px solid #F1F5F9;
        }

        .detail-field:nth-child(odd) {
            border-right: 1px solid #F1F5F9;
        }

        .detail-field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .detail-field-val {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
        }

        .download-box {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
        }

        .download-box-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 3px;
        }

        .download-box-text p {
            font-size: 13px;
            color: var(--muted);
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #166534;
            color: white;
            font-size: 13px;
            font-weight: 600;
            padding: 11px 22px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .download-btn:hover {
            background: #14532D;
        }

        .download-btn svg {
            width: 15px;
            height: 15px;
        }

        .auth-prompt {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 100%);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
        }

        .auth-prompt p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 14px;
            margin-bottom: 14px;
        }

        .auth-prompt-btns {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .auth-prompt-btn {
            background: var(--gold);
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 7px;
            text-decoration: none;
        }

        .auth-prompt-btn.outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 600px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-field:nth-child(odd) {
                border-right: none;
            }

            .pub-nav-link {
                display: none;
            }
        }
    </style>
</head>

<body>

    <nav class="pub-nav">
        <a class="pub-nav-brand" href="{{ url('/') }}">
            <div class="pub-nav-crest">L</div>
            <span class="pub-nav-title">LASU Project Repository</span>
        </a>
        <div class="pub-nav-links">
            <a href="{{ route('public.repository') }}" class="pub-nav-link">← Repository</a>
            <a href="{{ route('login') }}" class="pub-nav-link">Sign in</a>
            <a href="{{ route('register') }}" class="pub-nav-btn">Register</a>
        </div>
    </nav>

    <div class="detail-wrap">

        <div class="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('public.repository') }}">Repository</a>
            <span class="breadcrumb-sep">›</span>
            <span>{{ Str::limit($project->title, 50) }}</span>
        </div>

        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-approved"><span class="detail-approved-dot"></span>Approved & Archived</div>
                <h1 class="detail-title">{{ $project->title }}</h1>
                <div class="detail-meta-row">
                    <span class="detail-meta-item">📅 <strong>{{ $project->year }}</strong></span>
                    <span class="detail-meta-item">🏛 <strong>{{ $project->department->name ?? '—' }}</strong></span>
                    <span class="detail-meta-item">👤 <strong>{{ $project->student->name ?? '—' }}</strong></span>
                </div>
            </div>

            <div class="detail-grid">
                <div class="detail-field">
                    <div class="detail-field-label">Author</div>
                    <div class="detail-field-val">{{ $project->student->name ?? '—' }}</div>
                </div>
                <div class="detail-field">
                    <div class="detail-field-label">Supervisor</div>
                    <div class="detail-field-val">{{ $project->supervisor->name ?? '—' }}</div>
                </div>
                <div class="detail-field">
                    <div class="detail-field-label">Department</div>
                    <div class="detail-field-val">{{ $project->department->name ?? '—' }}</div>
                </div>
                <div class="detail-field">
                    <div class="detail-field-label">Year</div>
                    <div class="detail-field-val">{{ $project->year }}</div>
                </div>
                @if ($project->student?->matric_number)
                    <div class="detail-field">
                        <div class="detail-field-label">Matric Number</div>
                        <div class="detail-field-val">{{ $project->student->matric_number }}</div>
                    </div>
                @endif
                <div class="detail-field">
                    <div class="detail-field-label">Archived</div>
                    <div class="detail-field-val">{{ $project->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <div class="detail-body">
                <div class="section-label">Abstract</div>
                <div class="abstract-text">{{ $project->abstract }}</div>

                @if ($project->keywords)
                    <div class="keywords-row" style="margin-top:20px">
                        <div class="section-label" style="width:100%">Keywords</div>
                        @foreach (explode(',', $project->keywords) as $kw)
                            <span class="kw-chip">{{ trim($kw) }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Download (only for logged-in users) or auth prompt for guests --}}
        @auth
            <div class="download-box">
                <div class="download-box-text">
                    <h4>Project Document (PDF)</h4>
                    <p>Download the full final year project document.</p>
                </div>
                <a href="{{ route('repository.download', $project) }}" class="download-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
            </div>
        @else
            <div class="auth-prompt">
                <p>Create a free account or sign in to download the full PDF of this project.</p>
                <div class="auth-prompt-btns">
                    <a href="{{ route('register') }}" class="auth-prompt-btn">Create free account</a>
                    <a href="{{ route('login') }}" class="auth-prompt-btn outline">Sign in</a>
                </div>
            </div>
        @endauth

    </div>

</body>

</html>
