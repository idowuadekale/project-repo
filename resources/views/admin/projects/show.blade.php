<x-app-layout>
    <x-slot name="header">Project Detail</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Project Detail</h1>
            <p class="page-sub">{{ Str::limit($project->title, 60) }}</p>
        </div>
        <div class="page-header-right">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline">← Back</a>
            <a href="{{ route('admin.projects.download', $project) }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

        {{-- Left --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            <div class="card">
                <div class="card-header">
                    <span class="card-title">Project Information</span>
                    <span class="badge badge-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
                </div>
                <div class="card-body">
                    <h3
                        style="font-family:var(--font-display);font-size:18px;font-weight:800;
                                color:var(--text);margin-bottom:18px;line-height:1.3;">
                        {{ $project->title }}
                    </h3>

                    <div
                        style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));
                                gap:12px;margin-bottom:20px;">
                        @foreach ([['Student', $project->student->name ?? '—'], ['Matric No', $project->student?->matric_number ?? '—'], ['Supervisor', $project->supervisor->name ?? '—'], ['Department', $project->department->name ?? '—'], ['Year', $project->year], ['Submitted', $project->created_at->format('d M Y')]] as [$lbl, $val])
                            <div style="background:var(--surface2);border-radius:8px;padding:11px 13px;">
                                <div
                                    style="font-size:10.5px;font-weight:700;text-transform:uppercase;
                                            letter-spacing:0.07em;color:var(--text4);margin-bottom:4px;">
                                    {{ $lbl }}
                                </div>
                                <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $val }}</div>
                            </div>
                        @endforeach
                    </div>

                    @if ($project->keywords)
                        <div style="margin-bottom:18px;">
                            <div
                                style="font-size:11px;font-weight:700;text-transform:uppercase;
                                        letter-spacing:0.08em;color:var(--gold);margin-bottom:8px;">
                                Keywords</div>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach (explode(',', $project->keywords) as $kw)
                                    <span
                                        style="background:var(--info-bg);color:var(--info);
                                                 border:1px solid var(--info-bd);font-size:12px;
                                                 padding:3px 11px;border-radius:100px;">{{ trim($kw) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <div
                            style="font-size:11px;font-weight:700;text-transform:uppercase;
                                    letter-spacing:0.08em;color:var(--gold);margin-bottom:8px;">
                            Abstract</div>
                        <div
                            style="font-size:14px;line-height:1.8;color:var(--text2);
                                    background:var(--surface2);padding:18px;border-radius:10px;
                                    border-left:3px solid var(--gold);">
                            {{ $project->abstract }}
                        </div>
                    </div>

                    @if ($project->rejection_reason)
                        <div class="alert alert-error" style="margin-top:18px;">
                            <div class="alert-body">
                                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 9v2m0 4h.01" />
                                </svg>
                                <div>
                                    <strong>Rejection reason:</strong>
                                    {{ $project->rejection_reason }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Comments --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Comments ({{ $project->comments->count() }})</span>
                </div>
                <div>
                    @forelse($project->comments->sortBy('created_at') as $comment)
                        <div
                            style="padding:14px 20px;border-bottom:1px solid var(--border2);
                                    display:flex;gap:12px;">
                            <div
                                style="width:30px;height:30px;border-radius:50%;
                                        background:var(--surface2);border:1px solid var(--border);
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:11px;font-weight:700;color:var(--text3);
                                        flex-shrink:0;">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="display:flex;justify-content:space-between;margin-bottom:4px;gap:8px;flex-wrap:wrap;">
                                    <span style="font-size:13px;font-weight:700;color:var(--text);">
                                        {{ $comment->user->name }}
                                        <span class="badge badge-{{ $comment->user->role }}"
                                            style="margin-left:4px;font-size:10px;">
                                            {{ ucfirst($comment->user->role) }}
                                        </span>
                                    </span>
                                    <span style="font-size:11px;color:var(--text4);">
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                                <p style="font-size:13.5px;color:var(--text2);line-height:1.6;">
                                    {{ $comment->message }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div style="padding:24px 20px;text-align:center;color:var(--text4);font-size:13.5px;">
                            No comments on this project.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right: Admin actions --}}
        <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:76px;">

            {{-- Approve / Reject --}}
            @if (!$project->isApproved())
                <div class="card">
                    <div class="card-header">
                        <span class="card-title" style="color:var(--success);">Approve</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                            @csrf
                            <button type="submit" class="btn btn-success" style="width:100%;justify-content:center;"
                                onclick="return confirm('Approve this project?')">
                                ✅ Approve Project
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if (!$project->isRejected())
                <div class="card">
                    <div class="card-header">
                        <span class="card-title" style="color:var(--danger);">Reject</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.projects.reject', $project) }}">
                            @csrf
                            @error('rejection_reason')
                                <p class="form-error" style="margin-bottom:8px;">{{ $message }}</p>
                            @enderror
                            <div class="form-group">
                                <textarea name="rejection_reason" class="form-textarea no-icon" rows="3" required
                                    placeholder="Reason for rejection...">{{ old('rejection_reason') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;"
                                onclick="return confirm('Reject this project?')">
                                ❌ Reject Project
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Reassign supervisor --}}
            <div class="card">
                <div class="card-header"><span class="card-title">Reassign Supervisor</span></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.supervisor', $project) }}">
                        @csrf
                        <div class="form-group">
                            <div class="input-wrap no-icon">
                                <select name="supervisor_id" class="form-select" style="padding-left:13px;">
                                    <option value="">— Select supervisor —</option>
                                    @foreach ($supervisors as $sup)
                                        <option value="{{ $sup->id }}"
                                            {{ $project->supervisor_id == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                            Update Supervisor
                        </button>
                    </form>
                </div>
            </div>

            {{-- Delete --}}
            <div class="card" style="border-color:var(--danger-bd);">
                <div class="card-header" style="background:var(--danger-bg);">
                    <span class="card-title" style="color:var(--danger);">Danger Zone</span>
                </div>
                <div class="card-body">
                    <p style="font-size:12.5px;color:var(--text3);margin-bottom:12px;line-height:1.6;">
                        Permanently delete this project and its uploaded file. This cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                        onsubmit="return confirm('Permanently delete this project? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                            🗑 Delete Project
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media(max-width:900px) {
            div[style*="grid-template-columns:1fr 340px"] {
                display: flex !important;
                flex-direction: column !important;
            }

            div[style*="position:sticky;top:76px"] {
                position: static !important;
            }
        }
    </style>

</x-app-layout>
