<x-app-layout>
    <x-slot name="header">Reports</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Reports & Statistics</h1>
            <p class="page-sub">Departmental and yearly project breakdown</p>
        </div>
    </div>

    {{-- Summary stat cards --}}
    <div class="stat-grid" style="margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--surface2);">📁</div>
            <div class="stat-card-val">{{ $stats['total_projects'] }}</div>
            <div class="stat-card-lbl">Total Projects</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--success-bg);">✅</div>
            <div class="stat-card-val" style="color:var(--success);">{{ $stats['approved'] }}</div>
            <div class="stat-card-lbl">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--warning-bg);">⏳</div>
            <div class="stat-card-val" style="color:var(--warning);">{{ $stats['pending'] }}</div>
            <div class="stat-card-lbl">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:var(--danger-bg);">❌</div>
            <div class="stat-card-val" style="color:var(--danger);">{{ $stats['rejected'] }}</div>
            <div class="stat-card-lbl">Rejected</div>
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
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- By Department --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">By Department</span>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>Department</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">✅</th>
                            <th style="text-align:center;">⏳</th>
                            <th style="text-align:center;">❌</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byDepartment as $i => $dept)
                            <tr>
                                <td class="sn">{{ $i + 1 }}</td>
                                <td style="font-weight:600;font-size:13px;">{{ $dept->name }}</td>
                                <td style="text-align:center;font-weight:700;">{{ $dept->projects_count }}</td>
                                <td style="text-align:center;color:var(--success);font-weight:600;">
                                    {{ $dept->approved_count }}</td>
                                <td style="text-align:center;color:var(--warning);font-weight:600;">
                                    {{ $dept->pending_count }}</td>
                                <td style="text-align:center;color:var(--danger);font-weight:600;">
                                    {{ $dept->rejected_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:24px;color:var(--text4);">
                                    No data yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- By Year --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">By Year</span>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>Year</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">✅</th>
                            <th style="text-align:center;">⏳</th>
                            <th style="text-align:center;">❌</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byYear as $i => $row)
                            <tr>
                                <td class="sn">{{ $i + 1 }}</td>
                                <td style="font-weight:700;font-family:var(--font-display);">{{ $row->year }}</td>
                                <td style="text-align:center;font-weight:700;">{{ $row->total }}</td>
                                <td style="text-align:center;color:var(--success);font-weight:600;">
                                    {{ $row->approved }}</td>
                                <td style="text-align:center;color:var(--warning);font-weight:600;">{{ $row->pending }}
                                </td>
                                <td style="text-align:center;color:var(--danger);font-weight:600;">{{ $row->rejected }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:24px;color:var(--text4);">
                                    No data yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

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
