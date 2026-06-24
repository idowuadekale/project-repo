<x-app-layout>
    <x-slot name="header">Departments</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Departments</h1>
            <p class="page-sub">
                {{ $totalDepts }} department{{ $totalDepts != 1 ? 's' : '' }} &bull;
                {{ $totalProjects }} total project{{ $totalProjects != 1 ? 's' : '' }}
            </p>
        </div>
        <a href="{{ route('admin.departments.create') }}" class="btn btn-gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Add Department
        </a>
    </div>

    {{-- Search --}}
    <div class="card" style="margin-bottom:20px;padding:16px 20px;">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <div class="input-wrap" style="flex:1;min-width:200px;">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="search" class="form-input" value="{{ request('search') }}"
                    placeholder="Search department name...">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.departments.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    {{-- Department cards grid --}}
    @if ($departments->isEmpty())
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🏛</div>
                <div class="empty-state-title">No departments found</div>
                <div class="empty-state-sub">
                    <a href="{{ route('admin.departments.create') }}" style="color:var(--gold);font-weight:600;">
                        Add your first department →
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Table view --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <span class="card-title">
                    All Departments
                    <span style="color:var(--text4);font-weight:400;font-size:12px;margin-left:6px;">
                        ({{ $departments->total() }})
                    </span>
                </span>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>Department</th>
                            <th style="text-align:center;">Students</th>
                            <th style="text-align:center;">Supervisors</th>
                            <th style="text-align:center;">Total Projects</th>
                            <th style="text-align:center;">Approved</th>
                            <th style="text-align:center;">Pending</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $dept)
                            <tr>
                                <td class="sn">{{ $departments->firstItem() + $loop->index }}</td>
                                <td>
                                    <div>
                                        <div style="font-weight:700;font-size:13.5px;color:var(--text);">
                                            {{ $dept->name }}
                                        </div>
                                        @if ($dept->description)
                                            <div style="font-size:12px;color:var(--text4);margin-top:2px;">
                                                {{ $dept->description }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-size:14px;font-weight:700;color:var(--info);">
                                        {{ $dept->students_count }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-size:14px;font-weight:700;color:#6366F1;">
                                        {{ $dept->supervisors_count }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-size:14px;font-weight:700;color:var(--text);">
                                        {{ $dept->projects_count }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-size:13px;font-weight:700;color:var(--success);">
                                        {{ $dept->approved_count }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-size:13px;font-weight:700;color:var(--warning);">
                                        {{ $dept->pending_count }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;align-items:center;">
                                        <a href="{{ route('admin.departments.edit', $dept) }}"
                                            class="btn btn-outline btn-xs">
                                            Edit
                                        </a>

                                        {{-- Delete with smart confirmation --}}
                                        <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}"
                                            onsubmit="return confirmDelete(
                                                  event,
                                                  '{{ addslashes($dept->name) }}',
                                                  {{ $dept->projects_count }},
                                                  {{ $dept->approved_count }},
                                                  {{ $dept->pending_count }}
                                              )">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 20px;border-top:1px solid var(--border);">
                {{ $departments->withQueryString()->links() }}
            </div>
        </div>

        {{-- Visual cards below the table --}}
        <div
            style="display:grid;
                    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
                    gap:16px;">
            @foreach ($departments as $dept)
                <div style="background:var(--surface);
                            border:1px solid var(--border);
                            border-radius:14px;
                            overflow:hidden;
                            box-shadow:var(--shadow-sm);
                            transition:transform 0.2s,box-shadow 0.2s;
                            position:relative;"
                    onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--shadow-md)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow-sm)'">

                    {{-- Gold top accent --}}
                    <div
                        style="height:3px;
                                background:linear-gradient(90deg,var(--gold),transparent);">
                    </div>

                    <div style="padding:20px;">

                        {{-- Header --}}
                        <div
                            style="display:flex;align-items:flex-start;
                                    justify-content:space-between;gap:10px;
                                    margin-bottom:14px;">
                            <div
                                style="width:42px;height:42px;border-radius:11px;
                                        background:linear-gradient(135deg,var(--navy),var(--navy2));
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:20px;flex-shrink:0;">
                                🏛
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-weight:700;font-size:14px;
                                            color:var(--text);line-height:1.3;">
                                    {{ $dept->name }}
                                </div>
                                @if ($dept->description)
                                    <div
                                        style="font-size:11.5px;color:var(--text4);
                                                margin-top:3px;line-height:1.4;">
                                        {{ $dept->description }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Stats row --}}
                        <div
                            style="display:grid;grid-template-columns:repeat(3,1fr);
                                    gap:8px;margin-bottom:16px;">
                            @foreach ([['Students', $dept->students_count, 'var(--info)'], ['Supervisors', $dept->supervisors_count, '#6366F1'], ['Projects', $dept->projects_count, 'var(--gold)']] as [$lbl, $val, $color])
                                <div
                                    style="background:var(--surface2);
                                            border:1px solid var(--border);
                                            border-radius:9px;
                                            padding:10px 8px;
                                            text-align:center;">
                                    <div
                                        style="font-size:18px;font-weight:800;
                                                color:{{ $color }};
                                                font-family:var(--font-display);
                                                line-height:1;">
                                        {{ $val }}
                                    </div>
                                    <div
                                        style="font-size:10px;color:var(--text4);
                                                margin-top:3px;font-weight:600;
                                                text-transform:uppercase;letter-spacing:0.04em;">
                                        {{ $lbl }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Project status mini-bar --}}
                        @if ($dept->projects_count > 0)
                            @php
                                $approvedPct = ($dept->approved_count / $dept->projects_count) * 100;
                                $pendingPct = ($dept->pending_count / $dept->projects_count) * 100;
                                $rejectedPct = max(0, 100 - $approvedPct - $pendingPct);
                            @endphp
                            <div style="margin-bottom:14px;">
                                <div
                                    style="display:flex;justify-content:space-between;
                                            font-size:11px;color:var(--text4);
                                            margin-bottom:5px;">
                                    <span>Project status</span>
                                    <span>{{ $dept->projects_count }} total</span>
                                </div>
                                <div
                                    style="height:6px;border-radius:3px;
                                            background:var(--border);overflow:hidden;
                                            display:flex;">
                                    @if ($approvedPct > 0)
                                        <div
                                            style="width:{{ $approvedPct }}%;
                                                    background:var(--success);
                                                    transition:width 0.6s ease;">
                                        </div>
                                    @endif
                                    @if ($pendingPct > 0)
                                        <div
                                            style="width:{{ $pendingPct }}%;
                                                    background:var(--warning);
                                                    transition:width 0.6s ease;">
                                        </div>
                                    @endif
                                    @if ($rejectedPct > 0)
                                        <div
                                            style="width:{{ $rejectedPct }}%;
                                                    background:var(--danger);
                                                    transition:width 0.6s ease;">
                                        </div>
                                    @endif
                                </div>
                                <div style="display:flex;gap:10px;margin-top:5px;">
                                    @foreach ([['Approved', $dept->approved_count, 'var(--success)'], ['Pending', $dept->pending_count, 'var(--warning)']] as [$lbl, $cnt, $col])
                                        <div
                                            style="display:flex;align-items:center;
                                                    gap:4px;font-size:11px;color:var(--text4);">
                                            <span
                                                style="width:7px;height:7px;border-radius:50%;
                                                         background:{{ $col }};
                                                         display:inline-block;flex-shrink:0;"></span>
                                            {{ $lbl }}: <strong
                                                style="color:{{ $col }};">{{ $cnt }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div
                                style="margin-bottom:14px;font-size:12px;
                                        color:var(--text4);text-align:center;
                                        padding:8px;background:var(--surface2);
                                        border-radius:8px;">
                                No projects submitted yet
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline btn-sm"
                                style="flex:1;justify-content:center;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}"
                                onsubmit="return confirmDelete(
                                      event,
                                      '{{ addslashes($dept->name) }}',
                                      {{ $dept->projects_count }},
                                      {{ $dept->approved_count }},
                                      {{ $dept->pending_count }}
                                  )">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="justify-content:center;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        style="width:14px;height:14px;">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    @endif

    {{-- Smart delete confirmation script --}}
    <script>
        function confirmDelete(event, name, total, approved, pending) {
            event.preventDefault();

            let msg = `Delete the "${name}" department?\n\n`;

            if (total === 0) {
                msg += `This department has no projects. It will be permanently removed.`;
            } else {
                msg += `This department has ${total} project(s):\n\n`;

                if (approved > 0) {
                    msg += `• ${approved} approved project(s) will STAY in the repository\n`;
                    msg += `  (department label removed, data preserved)\n\n`;
                }

                if (pending > 0) {
                    msg += `• ${pending} pending/rejected project(s) will be PERMANENTLY DELETED\n\n`;
                }

                msg += `Users in this department will become unassigned.\n\n`;
                msg += `This action cannot be undone. Proceed?`;
            }

            if (confirm(msg)) {
                event.target.submit();
                return true;
            }
            return false;
        }
    </script>

</x-app-layout>
