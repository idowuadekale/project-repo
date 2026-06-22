<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Repository — LASU Faculty of Science</title>
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
            --gold-lt: #E8C97A;
            --cream: #F9F6EF;
            --slate: #4A5568;
            --muted: #718096;
            --white: #FFFFFF;
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

        /* Nav */
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
            align-items: center;
            gap: 6px;
        }

        .pub-nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
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
            transition: background 0.2s;
        }

        .pub-nav-btn:hover {
            background: var(--gold-lt);
        }

        /* Hero banner */
        .pub-hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 60%, #1a3a6e 100%);
            padding: 48px 1.5rem 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .pub-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(201, 168, 76, 0.06) 0%, transparent 70%);
        }

        .pub-hero-inner {
            position: relative;
            z-index: 1;
            max-width: 640px;
            margin: 0 auto;
        }

        .pub-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(201, 168, 76, 0.12);
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--gold);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 5px 13px;
            border-radius: 100px;
            margin-bottom: 18px;
        }

        .pub-hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
        }

        .pub-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(24px, 4vw, 38px);
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .pub-hero-sub {
            color: rgba(255, 255, 255, 0.55);
            font-size: 15px;
            line-height: 1.6;
        }

        .pub-hero-stat {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            padding: 8px 18px;
            border-radius: 100px;
        }

        .pub-hero-stat strong {
            color: var(--gold);
            font-weight: 700;
        }

        /* Search & filter bar */
        .filter-bar {
            background: white;
            border-bottom: 1px solid #E2E8F0;
            padding: 16px 1.5rem;
            position: sticky;
            top: 60px;
            z-index: 90;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .filter-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-search {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .filter-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #A0AEC0;
        }

        .filter-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            font-size: 13px;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            color: var(--navy);
            background: #FAFBFC;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.1);
        }

        .filter-select {
            padding: 10px 34px 10px 12px;
            font-size: 13px;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            color: var(--navy);
            background: #FAFBFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23A0AEC0' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right 10px center / 14px;
            font-family: 'Inter', sans-serif;
            appearance: none;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--gold);
        }

        .filter-btn {
            background: var(--navy);
            color: white;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .filter-btn:hover {
            background: var(--navy2);
        }

        .filter-clear {
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            padding: 10px;
        }

        .filter-clear:hover {
            color: var(--navy);
        }

        /* Main content */
        .pub-main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 1.5rem 60px;
        }

        /* Results info row */
        .results-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .results-info {
            font-size: 13px;
            color: var(--muted);
        }

        .results-info strong {
            color: var(--navy);
        }

        /* Project grid */
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 20px;
        }

        .proj-card {
            background: white;
            border: 1px solid #E8EDF2;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .proj-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(0, 0, 0, 0.09);
            border-color: rgba(201, 168, 76, 0.35);
        }

        .proj-card-top {
            padding: 20px 20px 0;
        }

        .proj-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .proj-dept {
            background: #EFF6FF;
            color: #1E40AF;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
        }

        .proj-year {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
        }

        .proj-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .proj-abstract {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .proj-keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 16px;
        }

        .proj-kw {
            background: #F7F8FA;
            color: #64748B;
            font-size: 11px;
            padding: 3px 9px;
            border-radius: 100px;
            border: 1px solid #E2E8F0;
        }

        .proj-card-footer {
            padding: 12px 20px;
            border-top: 1px solid #F1F5F9;
            background: #FAFBFC;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .proj-author {
            font-size: 12px;
            color: var(--muted);
        }

        .proj-author strong {
            color: var(--navy);
            font-weight: 600;
            display: block;
        }

        .proj-view-btn {
            background: var(--navy);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 7px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .proj-view-btn:hover {
            background: var(--gold);
            color: var(--navy);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-icon {
            font-size: 52px;
            margin-bottom: 16px;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .empty-sub {
            font-size: 14px;
            color: var(--muted);
        }

        /* Pagination */
        .pagination-wrap {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        /* CTA strip at bottom */
        .pub-cta {
            background: linear-gradient(135deg, var(--navy) 0%, #1a3a6e 100%);
            padding: 48px 1.5rem;
            text-align: center;
        }

        .pub-cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
        }

        .pub-cta p {
            color: rgba(255, 255, 255, 0.55);
            font-size: 14px;
            margin-bottom: 22px;
        }

        .pub-cta-btn {
            background: var(--gold);
            color: var(--navy);
            font-size: 14px;
            font-weight: 700;
            padding: 13px 30px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .pub-cta-btn:hover {
            background: var(--gold-lt);
        }

        footer.pub-footer {
            background: #06111F;
            padding: 24px 1.5rem;
            text-align: center;
        }

        footer.pub-footer p {
            color: rgba(255, 255, 255, 0.25);
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .pub-nav-link {
                display: none;
            }

            .project-grid {
                grid-template-columns: 1fr;
            }

            .results-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- Nav --}}
    <nav class="pub-nav">
        <a class="pub-nav-brand" href="{{ url('/') }}">
            <div class="pub-nav-crest">L</div>
            <span class="pub-nav-title">LASU Project Repository</span>
        </a>
        <div class="pub-nav-links">
            <a href="{{ url('/') }}" class="pub-nav-link">Home</a>
            <a href="{{ route('login') }}" class="pub-nav-link">Sign in</a>
            <a href="{{ route('register') }}" class="pub-nav-btn">Register</a>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="pub-hero">
        <div class="pub-hero-inner">
            <div class="pub-hero-badge">
                <span class="pub-hero-badge-dot"></span>
                Open Repository
            </div>
            <h1 class="pub-hero-title">Browse Approved Final Year Projects</h1>
            <p class="pub-hero-sub">Publicly accessible archive of approved research projects from the Faculty of
                Science, Lagos State University.</p>
            <div class="pub-hero-stat">
                <svg style="width:14px;height:14px;color:var(--gold)" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span><strong>{{ $total }}</strong> approved project{{ $total != 1 ? 's' : '' }} available</span>
            </div>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('public.repository') }}">
            <div class="filter-inner">
                <div class="filter-search">
                    <svg class="filter-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" name="search" class="filter-input" value="{{ request('search') }}"
                        placeholder="Search title, keyword or abstract...">
                </div>
                <select name="department" class="filter-select">
                    <option value="">All Departments</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                <select name="year" class="filter-select">
                    <option value="">All Years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
                <select name="sort" class="filter-select">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest first</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                    <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>A – Z</option>
                </select>
                <button type="submit" class="filter-btn">Search</button>
                @if (request()->hasAny(['search', 'department', 'year', 'sort']))
                    <a href="{{ route('public.repository') }}" class="filter-clear">Clear</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Results --}}
    <div class="pub-main">
        <div class="results-row">
            <p class="results-info">
                Showing <strong>{{ $projects->firstItem() }}–{{ $projects->lastItem() }}</strong>
                of <strong>{{ $projects->total() }}</strong> projects
                @if (request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
            </p>
            <p class="results-info">
                Page {{ $projects->currentPage() }} of {{ $projects->lastPage() }}
            </p>
        </div>

        @if ($projects->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <h3 class="empty-title">No projects found</h3>
                <p class="empty-sub">Try adjusting your search or filters.</p>
            </div>
        @else
            <div class="project-grid">
                @foreach ($projects as $project)
                    <div class="proj-card">
                        <div class="proj-card-top">
                            <div class="proj-meta">
                                <span class="proj-dept">{{ $project->department->name ?? '—' }}</span>
                                <span class="proj-year">{{ $project->year }}</span>
                            </div>
                            <h3 class="proj-title">{{ $project->title }}</h3>
                            <p class="proj-abstract">{{ Str::limit($project->abstract, 110) }}</p>
                            @if ($project->keywords)
                                <div class="proj-keywords">
                                    @foreach (array_slice(explode(',', $project->keywords), 0, 3) as $kw)
                                        <span class="proj-kw">{{ trim($kw) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="proj-card-footer">
                            <div class="proj-author">
                                <strong>By: {{ $project->student->name ?? '—' }}</strong>
                                Supervisor: {{ $project->supervisor->name ?? '—' }}
                            </div>
                            <a href="{{ route('public.repository.show', $project) }}" class="proj-view-btn">
                                View →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $projects->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- CTA strip --}}
    <div class="pub-cta">
        <h2>Want to submit your project?</h2>
        <p>Create a student account to submit your final year project for supervisor review and archiving.</p>
        <a href="{{ route('register') }}" class="pub-cta-btn">Create free account</a>
    </div>

    <footer class="pub-footer">
        <p>&copy; {{ date('Y') }} Lagos State University, Ojo - Faculty of Science. Developed by Adepemeji Samuel
            Adetomiwa.</p>
    </footer>

</body>

</html>
