<x-app-layout>
    <x-slot name="header">My Profile</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">My Profile</h1>
            <p class="page-sub">Manage your account information and security</p>
        </div>
    </div>

    <div style="max-width:760px;display:flex;flex-direction:column;gap:20px;">

        {{-- ── Profile photo card ───────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Profile Photo</span>
            </div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">

                    {{-- Avatar display --}}
                    <div style="position:relative;flex-shrink:0;">
                        <div id="avatarWrap"
                            style="width:96px;height:96px;border-radius:50%;
                                    overflow:hidden;border:3px solid rgba(201,168,76,0.4);
                                    background:var(--surface2);
                                    display:flex;align-items:center;justify-content:center;
                                    font-family:var(--font-display);font-size:28px;
                                    font-weight:800;color:var(--gold);
                                    cursor:pointer;position:relative;"
                            onclick="document.getElementById('photoInput').click()" title="Click to change photo">
                            @if ($user->profile_photo_path)
                                <img id="avatarImg" src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <span id="avatarInitials">{{ $user->initials }}</span>
                            @endif
                            {{-- Hover overlay --}}
                            <div style="position:absolute;inset:0;
                                        background:rgba(0,0,0,0.45);
                                        display:flex;align-items:center;justify-content:center;
                                        opacity:0;transition:opacity 0.2s;border-radius:50%;"
                                onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                    style="width:24px;height:24px;">
                                    <path
                                        d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                    <circle cx="12" cy="13" r="4" />
                                </svg>
                            </div>
                        </div>

                        {{-- Online indicator --}}
                        <div
                            style="position:absolute;bottom:3px;right:3px;
                                    width:16px;height:16px;border-radius:50%;
                                    background:var(--success);
                                    border:2px solid var(--surface);">
                        </div>
                    </div>

                    {{-- Photo actions --}}
                    <div style="flex:1;min-width:0;">
                        <div style="font-weight:700;font-size:16px;color:var(--text);margin-bottom:2px;">
                            {{ $user->name }}
                        </div>
                        <div style="font-size:13px;color:var(--text3);margin-bottom:14px;">
                            {{ $user->email }}
                            &bull;
                            <span class="badge badge-{{ $user->role }}" style="font-size:11px;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data"
                            id="photoForm">
                            @csrf
                            <input type="file" name="photo" id="photoInput"
                                accept="image/jpeg,image/png,image/webp" style="display:none;"
                                onchange="previewAndSubmit(this)">
                        </form>

                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <button type="button" class="btn btn-outline btn-sm"
                                onclick="document.getElementById('photoInput').click()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <path
                                        d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                    <circle cx="12" cy="13" r="4" />
                                </svg>
                                Change Photo
                            </button>

                            @if ($user->profile_photo_path)
                                <form method="POST" action="{{ route('profile.photo.remove') }}"
                                    onsubmit="return confirm('Remove your profile photo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </div>

                        <p style="font-size:11.5px;color:var(--text4);margin-top:10px;">
                            JPG, PNG or WebP &bull; Max 3MB &bull;
                            Will be cropped to 300×300px automatically
                        </p>

                        {{-- Upload progress --}}
                        <div id="uploadProgress" style="display:none;margin-top:10px;">
                            <div
                                style="height:4px;background:var(--border);
                                        border-radius:2px;overflow:hidden;">
                                <div style="height:100%;background:var(--gold);
                                            width:0%;transition:width 0.3s;
                                            border-radius:2px;"
                                    id="progressBar"></div>
                            </div>
                            <p style="font-size:12px;color:var(--text4);margin-top:4px;">
                                Uploading...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Profile info card ────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Personal Information</span>
            </div>
            <div class="card-body">

                @if ($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('bio'))
                    <div class="alert alert-error" style="margin-bottom:20px;">
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                @foreach ($errors->only(['name', 'email', 'phone', 'bio']) as $errs)
                                    @foreach ($errs as $e)
                                        <div style="font-size:12.5px;">• {{ $e }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <input type="text" name="name" class="form-input"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <input type="email" name="email" class="form-input"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.93 2.18 2 2 0 012.91 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                                </svg>
                                <input type="text" name="phone" class="form-input"
                                    value="{{ old('phone', $user->phone) }}" placeholder="e.g. +234 800 000 0000">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                                </svg>
                                <select name="department_id" class="form-select">
                                    <option value="">— Select —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Matric number (students only) --}}
                    @if ($user->isStudent())
                        <div class="form-group">
                            <label class="form-label">Matric Number</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                                </svg>
                                <input type="text" name="matric_number" class="form-input"
                                    value="{{ old('matric_number', $user->matric_number) }}"
                                    placeholder="e.g. 220115087">
                            </div>
                            @error('matric_number')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">
                            Bio
                            <span style="color:var(--text4);font-weight:400;">
                                (optional, max 300 characters)
                            </span>
                        </label>
                        <textarea name="bio" class="form-textarea no-icon" rows="3" maxlength="300"
                            placeholder="A brief description about yourself..." id="bioField">{{ old('bio', $user->bio) }}</textarea>
                        <p class="form-hint" id="bioCount">
                            {{ strlen($user->bio ?? '') }} / 300
                        </p>
                    </div>

                    <div style="display:flex;justify-content:flex-end;padding-top:4px;">
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

        {{-- ── Change password card ─────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Change Password</span>
            </div>
            <div class="card-body">

                @if ($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-error" style="margin-bottom:20px;">
                        <div class="alert-body">
                            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                @foreach ($errors->only(['current_password', 'password']) as $errs)
                                    @foreach ($errs as $e)
                                        <div style="font-size:12.5px;">• {{ $e }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert').remove()">✕</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Current Password *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input type="password" name="current_password" class="form-input" required
                                    placeholder="Enter current password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">New Password *</label>
                            <div class="input-wrap" style="position:relative;">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input type="password" name="password" id="newPassword" class="form-input" required
                                    placeholder="Min 8 characters" style="padding-right:40px;">
                                <button type="button" onclick="togglePwd('newPassword','eyeNew')"
                                    style="position:absolute;right:12px;top:50%;
                                               transform:translateY(-50%);
                                               background:none;border:none;
                                               cursor:pointer;color:var(--text4);">
                                    <svg id="eyeNew" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" style="width:16px;height:16px;">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            {{-- Strength indicator --}}
                            <div style="margin-top:6px;">
                                <div
                                    style="height:3px;background:var(--border);
                                            border-radius:2px;overflow:hidden;">
                                    <div id="strengthBar"
                                        style="height:100%;width:0%;
                                                transition:width 0.3s,background 0.3s;
                                                border-radius:2px;">
                                    </div>
                                </div>
                                <p id="strengthText" style="font-size:11px;color:var(--text4);margin-top:3px;"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944" />
                            </svg>
                            <input type="password" name="password_confirmation" class="form-input" required
                                placeholder="Re-enter new password">
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Account info card ────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Account Information</span>
            </div>
            <div class="card-body">
                <div
                    style="display:grid;
                            grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
                            gap:12px;">
                    @foreach ([['Account type', ucfirst($user->role)], ['Department', $user->department->name ?? 'Unassigned'], ['Member since', $user->created_at->format('d M Y')], ['Last updated', $user->updated_at->diffForHumans()]] as [$lbl, $val])
                        <div
                            style="background:var(--surface2);
                                    border:1px solid var(--border);
                                    border-radius:10px;padding:14px;">
                            <div
                                style="font-size:10.5px;font-weight:700;
                                        text-transform:uppercase;letter-spacing:0.07em;
                                        color:var(--text4);margin-bottom:5px;">
                                {{ $lbl }}
                            </div>
                            <div style="font-size:13.5px;font-weight:600;color:var(--text);">
                                {{ $val }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Danger zone ───────────────────────────────── --}}
        <div class="card" style="border-color:var(--danger-bd);">
            <div class="card-header" style="background:var(--danger-bg);">
                <span class="card-title" style="color:var(--danger);">
                    Danger Zone
                </span>
            </div>
            <div class="card-body">
                <div
                    style="display:flex;align-items:flex-start;
                            justify-content:space-between;gap:16px;flex-wrap:wrap;">
                    <div style="flex:1;min-width:0;">
                        <div
                            style="font-size:14px;font-weight:700;
                                    color:var(--text);margin-bottom:6px;">
                            Delete Account
                        </div>
                        <div style="font-size:13px;color:var(--text3);line-height:1.7;">
                            Once deleted, your account cannot be recovered.
                            @if ($user->isStudent())
                                Your <strong>approved projects</strong> will remain in the
                                repository. Pending and rejected projects will be
                                <strong style="color:var(--danger);">permanently deleted</strong>.
                            @elseif($user->isSupervisor())
                                Assigned projects will remain but become unassigned.
                            @else
                                Admin accounts cannot delete themselves here.
                            @endif
                        </div>
                    </div>
                    @if (!$user->isAdmin())
                        <button type="button" class="btn btn-danger" style="flex-shrink:0;"
                            onclick="document.getElementById('deleteModal').style.display='flex'">
                            Delete My Account
                        </button>
                    @else
                        <div class="btn btn-danger" style="opacity:0.4;cursor:not-allowed;flex-shrink:0;"
                            title="Admin accounts cannot self-delete">
                            Delete Account
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ── Delete confirmation modal ────────────────────── --}}
    @if (!$user->isAdmin())
        <div id="deleteModal"
            style="display:none;position:fixed;inset:0;
                    background:rgba(0,0,0,0.6);z-index:500;
                    align-items:center;justify-content:center;
                    padding:20px;">
            <div
                style="background:var(--surface);border-radius:16px;
                        padding:32px;max-width:440px;width:100%;
                        box-shadow:var(--shadow-lg);position:relative;">

                <div style="text-align:center;margin-bottom:24px;">
                    <div
                        style="width:56px;height:56px;border-radius:50%;
                                background:var(--danger-bg);border:2px solid var(--danger-bd);
                                display:flex;align-items:center;justify-content:center;
                                margin:0 auto 14px;font-size:24px;">
                        ⚠️
                    </div>
                    <h3
                        style="font-family:var(--font-display);font-size:20px;
                                font-weight:800;color:var(--text);margin-bottom:8px;">
                        Delete your account?
                    </h3>
                    <p style="font-size:13.5px;color:var(--text3);line-height:1.65;">
                        This action is <strong>permanent</strong> and cannot be undone.
                        Enter your password to confirm.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf @method('DELETE')

                    <div class="form-group">
                        <label class="form-label">Your Password *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" name="password" class="form-input" required autofocus
                                placeholder="Enter your password to confirm">
                        </div>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display:flex;gap:10px;margin-top:8px;">
                        <button type="button" class="btn btn-outline" style="flex:1;justify-content:center;"
                            onclick="document.getElementById('deleteModal').style.display='none'">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger" style="flex:1;justify-content:center;">
                            Yes, Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        // ── Bio character count ────────────────────────────
        const bioField = document.getElementById('bioField');
        const bioCount = document.getElementById('bioCount');
        if (bioField) {
            bioField.addEventListener('input', () => {
                const len = bioField.value.length;
                bioCount.textContent = `${len} / 300`;
                bioCount.style.color = len > 270 ? 'var(--warning)' : 'var(--text4)';
            });
        }

        // ── Password strength ──────────────────────────────
        const pwdField = document.getElementById('newPassword');
        const strengthBar = document.getElementById('strengthBar');
        const strengthTxt = document.getElementById('strengthText');

        if (pwdField) {
            pwdField.addEventListener('input', () => {
                const val = pwdField.value;
                let score = 0;
                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                const levels = [{
                        pct: '0%',
                        bg: 'var(--border)',
                        txt: ''
                    },
                    {
                        pct: '25%',
                        bg: 'var(--danger)',
                        txt: 'Weak'
                    },
                    {
                        pct: '50%',
                        bg: 'var(--warning)',
                        txt: 'Fair'
                    },
                    {
                        pct: '75%',
                        bg: 'var(--info)',
                        txt: 'Good'
                    },
                    {
                        pct: '100%',
                        bg: 'var(--success)',
                        txt: 'Strong'
                    },
                ];

                const level = levels[score] || levels[0];
                strengthBar.style.width = level.pct;
                strengthBar.style.background = level.bg;
                strengthTxt.textContent = level.txt;
                strengthTxt.style.color = level.bg;
            });
        }

        // ── Toggle password visibility ─────────────────────
        function togglePwd(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                eye.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>`;
            }
        }

        // ── Avatar preview before upload ───────────────────
        function previewAndSubmit(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            if (file.size > 3 * 1024 * 1024) {
                alert('File too large. Maximum size is 3MB.');
                input.value = '';
                return;
            }

            // Show preview immediately
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrap = document.getElementById('avatarWrap');
                let img = document.getElementById('avatarImg');
                if (!img) {
                    wrap.innerHTML = '';
                    img = document.createElement('img');
                    img.id = 'avatarImg';
                    img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
                    wrap.appendChild(img);
                }
                img.src = e.target.result;

                // Show progress
                const prog = document.getElementById('uploadProgress');
                const bar = document.getElementById('progressBar');
                prog.style.display = 'block';

                // Animate progress bar then submit
                let pct = 0;
                const interval = setInterval(() => {
                    pct = Math.min(pct + 8, 85);
                    bar.style.width = pct + '%';
                }, 80);

                // Submit form
                document.getElementById('photoForm').submit();
            };
            reader.readAsDataURL(file);
        }

        // ── Close modal on outside click ───────────────────
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });
        }
    </script>

</x-app-layout>
