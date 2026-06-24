<x-app-layout>
    <x-slot name="header">Manage Projects</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Projects</h1>
            <p class="page-sub">View and manage all project submissions</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card" style="margin-bottom:20px;padding:16px 20px;">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <div class="input-wrap" style="flex:1;min-width:200px;">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="search" class="form-input" value="{{ request('search') }}"
                    placeholder="Search title or keywords...">
            </div>
            <div class="input-wrap no-icon">
                <select name="status" class="form-select" style="padding-left:13px;">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-wrap no-icon">
                <select name="year" class="form-select" style="padding-left:13px;">
                    <option value="">All years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if (request()->hasAny(['search', 'status', 'year']))
                <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                All Projects
                <span style="color:var(--text4);font-weight:400;font-size:12px;margin-left:6px;">
                    ({{ $projects->total() }})
                </span>
            </span>
        </div>

        @if ($projects->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📂</div>
                <div class="empty-state-title">No projects found</div>
                <div class="empty-state-sub">Try adjusting your filters.</div>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>Title</th>
                            <th>Student</th>
                            <th>Supervisor</th>
                            <th>Dept</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="sn">{{ $projects->firstItem() + $loop->index }}</td>
                                <td>
                                    <div style="font-weight:600;max-width:200px;white-space:nowrap;
                                                overflow:hidden;text-overflow:ellipsis;"
                                        title="{{ $project->title }}">
                                        {{ $project->title }}
                                    </div>
                                </td>
                                <td style="font-size:12.5px;color:var(--text2);">
                                    {{ $project->student->name ?? '—' }}
                                </td>
                                <td style="font-size:12.5px;color:var(--text2);">
                                    {{ $project->supervisor->name ?? '—' }}
                                </td>
                                <td style="font-size:12px;color:var(--text3);">
                                    {{ Str::limit($project->department->name ?? '—', 14) }}
                                </td>
                                <td style="color:var(--text3);">{{ $project->year }}</td>
                                <td>
                                    <span class="badge badge-{{ $project->status }}">
                                        <span class="badge-dot"
                                            style="background:{{ $project->status === 'approved' ? 'var(--success)' : ($project->status === 'rejected' ? 'var(--danger)' : 'var(--warning)') }};"></span>
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td style="font-size:12px;color:var(--text4);white-space:nowrap;">
                                    {{ $project->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    <div style="display:flex;gap:5px;">
                                        <a href="{{ route('admin.projects.show', $project) }}"
                                            class="btn btn-outline btn-xs">View</a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                            onsubmit="return confirm('Delete this project and its file permanently?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-xs">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 20px;border-top:1px solid var(--border);">
                {{ $projects->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
