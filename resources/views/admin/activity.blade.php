<x-app-layout>
    <x-slot name="header">Activity Log</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Activity Log</h1>
            <p class="page-sub">Complete audit trail of all system actions</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card" style="margin-bottom:20px;padding:16px 20px;">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <div class="input-wrap" style="flex:1;min-width:200px;">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="search" class="form-input" value="{{ request('search') }}"
                    placeholder="Search action or subject...">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.activity') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                Log Entries
                <span style="color:var(--text4);font-weight:400;font-size:12px;margin-left:6px;">
                    ({{ $logs->total() }})
                </span>
            </span>
        </div>

        @if ($logs->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">No activity recorded yet</div>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>Subject</th>
                            <th>IP Address</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td class="sn">{{ $logs->firstItem() + $loop->index }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div
                                            style="width:28px;height:28px;border-radius:50%;
                                                    background:rgba(201,168,76,0.1);
                                                    border:1px solid rgba(201,168,76,0.2);
                                                    display:flex;align-items:center;justify-content:center;
                                                    font-size:11px;font-weight:700;color:var(--gold);
                                                    flex-shrink:0;">
                                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <span style="font-size:13px;font-weight:600;color:var(--text);">
                                            {{ $log->user->name ?? 'System' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if ($log->user)
                                        <span class="badge badge-{{ $log->user->role }}">
                                            {{ ucfirst($log->user->role) }}
                                        </span>
                                    @else
                                        <span class="badge badge-student">—</span>
                                    @endif
                                </td>
                                <td style="font-size:13px;color:var(--text2);">{{ $log->action }}</td>
                                <td style="font-size:12.5px;color:var(--text3);font-style:italic;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                                    title="{{ $log->subject }}">
                                    {{ $log->subject ?? '—' }}
                                </td>
                                <td style="font-size:12px;color:var(--text4);font-family:monospace;">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                                <td style="font-size:12px;color:var(--text4);white-space:nowrap;">
                                    <div>{{ $log->created_at->format('d M Y') }}</div>
                                    <div style="font-size:11px;">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 20px;border-top:1px solid var(--border);">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
