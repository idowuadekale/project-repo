<x-app-layout>
    <x-slot name="header">Manage Users</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Users</h1>
            <p class="page-sub">Manage all registered accounts</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Add User
        </a>
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
                    placeholder="Search name, email or matric no...">
            </div>
            <div class="input-wrap no-icon">
                <select name="role" class="form-select" style="padding-left:13px;">
                    <option value="">All roles</option>
                    @foreach (['student', 'supervisor', 'admin'] as $r)
                        <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>
                            {{ ucfirst($r) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-wrap no-icon">
                <select name="department" class="form-select" style="padding-left:13px;">
                    <option value="">All departments</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if (request()->hasAny(['search', 'role', 'department']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                All Users
                <span style="color:var(--text4);font-weight:400;font-size:12px;margin-left:6px;">
                    ({{ $users->total() }})
                </span>
            </span>
        </div>

        @if ($users->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">👤</div>
                <div class="empty-state-title">No users found</div>
                <div class="empty-state-sub">Try adjusting your filters.</div>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sn">#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Matric No</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="sn">{{ $users->firstItem() + $loop->index }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div
                                            style="width:32px;height:32px;border-radius:50%;
                                                    background:var(--surface2);border:1px solid var(--border);
                                                    display:flex;align-items:center;justify-content:center;
                                                    font-size:12px;font-weight:700;color:var(--text3);
                                                    flex-shrink:0;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600;font-size:13px;color:var(--text);">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:12.5px;color:var(--text3);">{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td style="font-size:12.5px;color:var(--text2);">
                                    {{ $user->department->name ?? '—' }}
                                </td>
                                <td style="font-size:12.5px;color:var(--text3);">
                                    {{ $user->matric_number ?? '—' }}
                                </td>
                                <td style="font-size:12px;color:var(--text4);white-space:nowrap;">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-outline btn-xs">Edit</a>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                onsubmit="return confirm('Delete {{ $user->name }}? Their pending/rejected projects will be deleted. Approved projects remain in the repository.')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-xs">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 20px;border-top:1px solid var(--border);">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
