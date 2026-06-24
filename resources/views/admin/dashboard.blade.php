<x-app-layout>
    <x-slot name="header">Admin Dashboard</x-slot>

    {{-- Welcome banner --}}
    <div
        style="background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 60%,#1a3a6e 100%);
                border-radius:16px;padding:28px 32px;margin-bottom:28px;
                position:relative;overflow:hidden;">
        <div
            style="position:absolute;inset:0;
                    background:radial-gradient(ellipse 60% 80% at 80% 40%,rgba(201,168,76,0.08) 0%,transparent 70%);
                    pointer-events:none;">
        </div>
        <div
            style="position:relative;z-index:1;
                    display:flex;align-items:center;justify-content:space-between;
                    flex-wrap:wrap;gap:16px;">
            <div>
                <p
                    style="color:rgba(255,255,255,0.5);font-size:12px;font-weight:600;
                           letter-spacing:0.08em;text-transform:uppercase;margin-bottom:6px;">
                    Admin Portal
                </p>
                <h2
                    style="font-family:var(--font-display);font-size:clamp(20px,3vw,26px);
                            font-weight:800;color:#fff;margin-bottom:6px;">
                    {{ auth()->user()->name }}
                </h2>
                <p style="color:rgba(255,255,255,0.5);font-size:13px;">
                    System Administrator
                    @if ($stats['pending'] > 0)
                        &bull;
                        <span style="color:var(--gold);font-weight:600;">
                            {{ $stats['pending'] }} project{{ $stats['pending'] > 1 ? 's' : '' }} pending
                        </span>
                    @endif
                </p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <a href="{{ route('admin.users.create') }}" class="btn btn-gold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Add User
                </a>
                <a href="{{ route('admin.reports') }}" class="btn btn-outline"
                    style="border-color:rgba(255,255,255,0.2);color:rgba(255,255,255,0.8);">
                    Reports
                </a>
            </div>
        </div>
    </div>

    {{-- Stats grid --}}
    <div class="stat-grid" style="margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#EFF6FF;">👥</div>
            <div class="stat-card-val">{{ $stats['total_users'] }}</div>
            <div class="stat-card-lbl">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--info-bg);">🎓</div>
            <div class="stat-card-val" style="color:var(--info);">{{ $stats['total_students'] }}</div>
            <div class="stat-card-lbl">Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#F3F4FF;">👨‍🏫</div>
            <div class="stat-card-val" style="color:#6366F1;">{{ $stats['total_supervisors'] }}</div>
            <div class="stat-card-lbl">Supervisors</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--surface2);">🏛</div>
            <div class="stat-card-val">{{ $stats['total_departments'] }}</div>
            <div class="stat-card-lbl">Departments</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--surface2);">📁</div>
            <div class="stat-card-val">{{ $stats['total_projects'] }}</div>
            <div class="stat-card-lbl">Total Projects</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--warning-bg);">⏳</div>
            <div class="stat-card-val" style="color:var(--warning);">{{ $stats['pending'] }}</div>
            <div class="stat-card-lbl">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--success-bg);">✅</div>
            <div class="stat-card-val" style="color:var(--success);">{{ $stats['approved'] }}</div>
            <div class="stat-card-lbl">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--danger-bg);">❌</div>
            <div class="stat-card-val" style="color:var(--danger);">{{ $stats['rejected'] }}</div>
            <div class="stat-card-lbl">Rejected</div>
        </div>
    </div>

    {{-- Main grid --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

        {{-- Recent projects --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Recent Projects</span>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline btn-sm">View all</a>
            </div>
            @if ($recentProjects->isEmpty())
                <div class="empty-state" style="padding:32px 20px;">
                    <div class="empty-state-icon">📂</div>
                    <div class="empty-state-title">No projects yet</div>
                </div>
            @else
                <div>
                    @foreach ($recentProjects as $i => $project)
                        <div
                            style="padding:12px 20px;border-bottom:1px solid var(--border2);
                                    display:flex;align-items:center;gap:12px;">
                            <div
                                style="width:28px;height:28px;border-radius:6px;
                                        background:var(--surface2);border:1px solid var(--border);
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:11px;font-weight:700;color:var(--text4);
                                        flex-shrink:0;">
                                {{ $i + 1 }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-size:13px;font-weight:600;color:var(--text);
                                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $project->title }}
                                </div>
                                <div style="font-size:11.5px;color:var(--text3);margin-top:1px;">
                                    {{ $project->student->name ?? '—' }}
                                    &bull; {{ $project->year }}
                                </div>
                            </div>
                            <span class="badge badge-{{ $project->status }}" style="flex-shrink:0;">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Recent activity --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Recent Activity</span>
                <a href="{{ route('admin.activity') }}" class="btn btn-outline btn-sm">View all</a>
            </div>
            @if ($recentLogs->isEmpty())
                <div class="empty-state" style="padding:32px 20px;">
                    <div class="empty-state-icon">📋</div>
                    <div class="empty-state-title">No activity yet</div>
                </div>
            @else
                <div>
                    @foreach ($recentLogs as $log)
                        <div
                            style="padding:11px 20px;border-bottom:1px solid var(--border2);
                                    display:flex;gap:10px;align-items:flex-start;">
                            <div
                                style="width:28px;height:28px;border-radius:50%;
                                        background:rgba(201,168,76,0.1);
                                        border:1px solid rgba(201,168,76,0.2);
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:11px;font-weight:700;color:var(--gold);
                                        flex-shrink:0;margin-top:1px;">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:12.5px;color:var(--text);">
                                    <strong>{{ $log->user->name ?? 'System' }}</strong>
                                    {{ $log->action }}
                                    @if ($log->subject)
                                        — <span style="color:var(--text3);font-style:italic;">
                                            {{ Str::limit($log->subject, 30) }}
                                        </span>
                                    @endif
                                </div>
                                <div style="font-size:11px;color:var(--text4);margin-top:2px;">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Recent users --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Recently Registered Users</span>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Manage users</a>
        </div>
        @if ($recentUsers->isEmpty())
            <div class="empty-state" style="padding:32px 20px;">
                <div class="empty-state-icon">👤</div>
                <div class="empty-state-title">No users yet</div>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentUsers as $i => $user)
                            <tr>
                                <td class="sn">{{ $i + 1 }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div
                                            style="width:30px;height:30px;border-radius:50%;
                                                    background:var(--surface2);border:1px solid var(--border);
                                                    display:flex;align-items:center;justify-content:center;
                                                    font-size:12px;font-weight:700;color:var(--text3);
                                                    flex-shrink:0;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span style="font-weight:600;font-size:13px;">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td style="color:var(--text3);font-size:12.5px;">{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td style="font-size:12.5px;color:var(--text2);">
                                    {{ $user->department->name ?? '—' }}
                                </td>
                                <td style="font-size:12px;color:var(--text4);white-space:nowrap;">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <style>
        @media(max-width:768px) {
            div[style*="grid-template-columns:1fr 1fr"] {
                display: flex !important;
                flex-direction: column !important;
            }
        }
    </style>

</x-app-layout>
