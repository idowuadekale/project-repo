<x-app-layout>
    <x-slot name="header">Add User</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Add New User</h1>
            <p class="page-sub">Create a student, supervisor or admin account</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <div style="max-width:680px;">
        <div class="card">
            <div class="card-header"><span class="card-title">Account Details</span></div>
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

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required
                                placeholder="Full name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required
                                placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Role *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <select name="role" class="form-select" required>
                                    @foreach (['student', 'supervisor', 'admin'] as $r)
                                        <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>
                                            {{ ucfirst($r) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3" />
                                </svg>
                                <select name="department_id" class="form-select">
                                    <option value="">— Select —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Matric Number
                            <span style="color:var(--text4);font-weight:400;">(students only)</span>
                        </label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <input type="text" name="matric_number" class="form-input"
                                value="{{ old('matric_number') }}" placeholder="e.g. 220115087">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input type="password" name="password" class="form-input" required
                                    placeholder="Minimum 8 characters">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04" />
                                </svg>
                                <input type="password" name="password_confirmation" class="form-input" required
                                    placeholder="Re-enter password">
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:8px;">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            Create User
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>
