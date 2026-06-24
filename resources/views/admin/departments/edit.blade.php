<x-app-layout>
    <x-slot name="header">Edit Department</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Edit Department</h1>
            <p class="page-sub">{{ $department->name }}</p>
        </div>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <div style="max-width:560px;display:flex;flex-direction:column;gap:16px;">

        {{-- Edit form --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Department Details</span>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-error" style="margin-bottom:20px;">
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                @foreach ($errors->all() as $e)
                                    <div style="font-size:12.5px;">• {{ $e }}</div>
                                @endforeach
                            </div>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.departments.update', $department) }}">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Department Name *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5" />
                            </svg>
                            <input type="text" name="name" class="form-input"
                                value="{{ old('name', $department->name) }}" required autofocus>
                        </div>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Description
                            <span style="color:var(--text4);font-weight:400;">(optional)</span>
                        </label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" style="top:16px;transform:none;">
                                <path d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            <textarea name="description" class="form-textarea" rows="3" style="padding-left:38px;">{{ old('description', $department->description) }}</textarea>
                        </div>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        style="display:flex;justify-content:space-between;
                                align-items:center;padding-top:8px;">
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Department stats --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Department Statistics</span>
            </div>
            <div class="card-body">
                <div
                    style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;
                            margin-bottom:18px;">
                    @foreach ([['Students', $department->students_count, 'var(--info)'], ['Supervisors', $department->supervisors_count, '#6366F1'], ['Projects', $department->projects_count, 'var(--gold)']] as [$lbl, $val, $col])
                        <div
                            style="background:var(--surface2);border:1px solid var(--border);
                                    border-radius:10px;padding:14px;text-align:center;">
                            <div
                                style="font-size:24px;font-weight:800;color:{{ $col }};
                                        font-family:var(--font-display);line-height:1;">
                                {{ $val }}
                            </div>
                            <div
                                style="font-size:11px;color:var(--text4);margin-top:4px;
                                        font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">
                                {{ $lbl }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <p style="font-size:12.5px;color:var(--text3);line-height:1.6;">
                    Renaming this department will update the name across all linked users
                    and projects automatically.
                </p>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="card" style="border-color:var(--danger-bd);">
            <div class="card-header" style="background:var(--danger-bg);">
                <span class="card-title" style="color:var(--danger);">Danger Zone</span>
            </div>
            <div class="card-body">
                <p style="font-size:13px;color:var(--text2);line-height:1.7;margin-bottom:16px;">
                    Deleting this department will:
                </p>
                <ul
                    style="font-size:13px;color:var(--text3);line-height:1.8;
                           padding-left:18px;margin-bottom:18px;list-style:disc;">
                    <li>
                        Keep all <strong style="color:var(--success);">
                            {{ $department->approved_count ?? 0 }} approved
                        </strong> projects in the repository (department label removed)
                    </li>
                    <li>
                        Permanently delete
                        <strong style="color:var(--danger);">
                            {{ ($department->projects_count ?? 0) - ($department->approved_count ?? 0) }}
                            pending/rejected
                        </strong> projects and their files
                    </li>
                    <li>
                        Leave
                        <strong>{{ $department->users_count ?? 0 }} user(s)</strong>
                        unassigned (they keep their accounts)
                    </li>
                </ul>
                <form method="POST" action="{{ route('admin.departments.destroy', $department) }}"
                    onsubmit="return confirmDelete(
                          event,
                          '{{ addslashes($department->name) }}',
                          {{ $department->projects_count ?? 0 }},
                          {{ $department->approved_count ?? 0 }},
                          {{ ($department->projects_count ?? 0) - ($department->approved_count ?? 0) }}
                      )">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width:15px;height:15px;">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        </svg>
                        Delete This Department
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(event, name, total, approved, pending) {
            event.preventDefault();
            let msg = `Delete the "${name}" department?\n\n`;
            if (total === 0) {
                msg += `No projects exist. It will be permanently removed.`;
            } else {
                if (approved > 0)
                    msg += `• ${approved} approved project(s) stay in repository\n`;
                if (pending > 0)
                    msg += `• ${pending} pending/rejected project(s) permanently deleted\n`;
                msg += `\nThis cannot be undone. Proceed?`;
            }
            if (confirm(msg)) {
                event.target.submit();
                return true;
            }
            return false;
        }
    </script>

</x-app-layout>
