<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — LASU Project Repository</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="app-shell">

        {{-- ── SIDEBAR ──────────────────────────────────── --}}
        <aside class="sidebar" id="sidebar">

            {{-- Brand --}}
            <a href="{{ url('/') }}" class="sidebar-brand">
                <div class="sidebar-crest">L</div>
                <div class="sidebar-brand-text">
                    <div class="sidebar-brand-name">LASU Repository</div>
                    <div class="sidebar-brand-sub">Faculty of Science</div>
                </div>
            </a>

            {{-- User info --}}
            <div class="sidebar-user">
                @if (auth()->user()->profile_photo_path)
                    <img src="{{ auth()->user()->profile_photo_path }}" alt="" class="sidebar-avatar">
                @else
                    <div class="sidebar-avatar-placeholder">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div style="min-width:0;flex:1">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ auth()->user()->role }}</div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav" style="flex:1">

                @if (auth()->user()->isAdmin())
                    <div class="sidebar-section-label">Main</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('repository.index') }}"
                        class="sidebar-link {{ request()->routeIs('repository.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Repository
                    </a>

                    <div class="sidebar-section-label">Management</div>
                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Projects
                        @php $pending = \App\Models\Project::where('status','pending')->count(); @endphp
                        @if ($pending > 0)
                            <span class="sidebar-link-badge">{{ $pending }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3" />
                        </svg>
                        Departments
                    </a>

                    <div class="sidebar-section-label">Reports</div>
                    <a href="{{ route('admin.reports') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reports
                    </a>
                    <a href="{{ route('admin.activity') }}"
                        class="sidebar-link {{ request()->routeIs('admin.activity') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Activity Log
                    </a>
                @elseif(auth()->user()->isSupervisor())
                    <div class="sidebar-section-label">Main</div>
                    <a href="{{ route('supervisor.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('supervisor.projects.index') }}"
                        class="sidebar-link {{ request()->routeIs('supervisor.projects.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Assigned Projects
                        @php
                            $myPending = \App\Models\Project::where('supervisor_id', auth()->id())
                                ->where('status', 'pending')
                                ->count();
                        @endphp
                        @if ($myPending > 0)
                            <span class="sidebar-link-badge">{{ $myPending }}</span>
                        @endif
                    </a>
                    <a href="{{ route('repository.index') }}"
                        class="sidebar-link {{ request()->routeIs('repository.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Repository
                    </a>
                @else
                    <div class="sidebar-section-label">Main</div>
                    <a href="{{ route('student.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('student.projects.index') }}"
                        class="sidebar-link {{ request()->routeIs('student.projects.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        My Projects
                    </a>
                    <a href="{{ route('student.projects.create') }}"
                        class="sidebar-link {{ request()->routeIs('student.projects.create') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 4v16m8-8H4" />
                        </svg>
                        Submit Project
                    </a>
                    <a href="{{ route('repository.index') }}"
                        class="sidebar-link {{ request()->routeIs('repository.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Repository
                    </a>
                @endif

            </nav>

            {{-- Sidebar footer --}}
            <div class="sidebar-footer">
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link"
                        style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- ── MAIN CONTENT ──────────────────────────── --}}
        <div class="main-content">

            {{-- Topbar --}}
            <div class="topbar">
                <button class="topbar-menu-btn" id="menuBtn" aria-label="Toggle menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="topbar-title">{{ $header ?? '' }}</div>
                <div class="topbar-right">
                    <button class="theme-toggle" id="themeToggle" title="Toggle dark mode"
                        aria-label="Toggle theme">
                        <span id="themeIcon">🌙</span>
                    </button>
                </div>
            </div>

            {{-- Flash alerts --}}
            <div style="padding: 16px 28px 0" id="alertContainer">
                @if (session('success'))
                    <div class="alert alert-success" data-auto-dismiss>
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error" data-auto-dismiss>
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning" data-auto-dismiss>
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>{{ session('warning') }}</span>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif
            </div>

            {{-- Page content --}}
            <div class="page-content">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <footer
                style="padding:16px 28px; border-top: 1px solid var(--border); text-align:center; font-size:12px; color:var(--text4);">
                &copy; {{ date('Y') }} LASU Faculty of Science — Project Repository &bull; Adepemeji Samuel
                Adetomiwa
            </footer>
        </div>
    </div>

    <script>
        // ── Dark / Light mode ─────────────────────────────
        const toggle = document.getElementById('themeToggle');
        const icon = document.getElementById('themeIcon');
        const html = document.documentElement;

        function setTheme(theme) {
            html.setAttribute('data-theme', theme);
            icon.textContent = theme === 'dark' ? '☀️' : '🌙';
            localStorage.setItem('theme', theme);
        }

        // Load saved theme
        const saved = localStorage.getItem('theme') || 'light';
        setTheme(saved);

        toggle.addEventListener('click', () => {
            setTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });

        // ── Mobile sidebar ────────────────────────────────
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('menuBtn');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });

        // ── Auto-dismiss alerts after 8s ─────────────────
        document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-6px)';
                setTimeout(() => el.remove(), 400);
            }, 8000);
        });
    </script>

</body>

</html>
