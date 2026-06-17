<x-guest-layout>

    <style>
        .auth-h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 800;
            color: #0B1D3A;
            margin-bottom: 6px;
        }

        .auth-p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 26px;
        }

        .field-group {
            margin-bottom: 16px;
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #0B1D3A;
            margin-bottom: 7px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            color: #A0AEC0;
            pointer-events: none;
        }

        .field-input,
        .field-select {
            width: 100%;
            padding: 12px 14px 12px 42px;
            font-size: 14px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            color: #0B1D3A;
            background: #FAFBFC;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            font-family: 'Inter', sans-serif;
            appearance: none;
        }

        .field-select {
            padding-left: 42px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23A0AEC0' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
        }

        .field-input:focus,
        .field-select:focus {
            outline: none;
            border-color: #C9A84C;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
            background: #fff;
        }

        .field-error {
            color: #E24B4A;
            font-size: 12.5px;
            margin-top: 6px;
        }

        .field-hint {
            color: #A0AEC0;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Role selector — segmented control */
        .role-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 18px;
        }

        .role-option {
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 14px 12px;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.2s, background 0.2s;
            position: relative;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-option-icon {
            font-size: 22px;
            margin-bottom: 6px;
        }

        .role-option-label {
            font-size: 13px;
            font-weight: 600;
            color: #4A5568;
        }

        .role-option.active {
            border-color: #C9A84C;
            background: #FAF6EA;
        }

        .role-option.active .role-option-label {
            color: #0B1D3A;
        }

        .btn-submit {
            width: 100%;
            background: #0B1D3A;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 13px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            margin-top: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-submit:hover {
            background: #112348;
            transform: translateY(-1px);
        }

        .btn-submit svg {
            width: 16px;
            height: 16px;
        }

        .auth-footer-link {
            text-align: center;
            font-size: 13.5px;
            color: #718096;
            margin-top: 22px;
        }

        .auth-footer-link a {
            color: #C9A84C;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .field-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h1 class="auth-h1">Create your account</h1>
    <p class="auth-p">Join the departmental project repository</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Role selector --}}
        <label class="field-label" style="margin-bottom:10px;">I am registering as a</label>
        <div class="role-toggle" id="role-toggle">
            <label class="role-option {{ old('role', 'student') === 'student' ? 'active' : '' }}" data-role="student">
                <input type="radio" name="role" value="student"
                    {{ old('role', 'student') === 'student' ? 'checked' : '' }}>
                <div class="role-option-icon">🎓</div>
                <div class="role-option-label">Student</div>
            </label>
            <label class="role-option {{ old('role') === 'supervisor' ? 'active' : '' }}" data-role="supervisor">
                <input type="radio" name="role" value="supervisor"
                    {{ old('role') === 'supervisor' ? 'checked' : '' }}>
                <div class="role-option-icon">👨‍🏫</div>
                <div class="role-option-label">Supervisor</div>
            </label>
        </div>
        @error('role')
            <p class="field-error" style="margin-bottom:14px;">{{ $message }}</p>
        @enderror

        {{-- Name --}}
        <div class="field-group">
            <label class="field-label" for="name">Full name</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <input id="name" class="field-input" type="text" name="name" value="{{ old('name') }}"
                    required autofocus autocomplete="name" placeholder="e.g. Adepemeji Samuel Adetomiwa">
            </div>
            @error('name')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="field-group">
            <label class="field-label" for="email">Email address</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}"
                    required autocomplete="username" placeholder="you@lasu.edu.ng">
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Matric number + Department --}}
        <div class="field-row">
            <div class="field-group" id="matric-wrapper">
                <label class="field-label" for="matric_number">Matric number</label>
                <div class="field-wrap">
                    <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <input id="matric_number" class="field-input" type="text" name="matric_number"
                        value="{{ old('matric_number') }}" placeholder="220115087">
                </div>
                @error('matric_number')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="department_id">Department</label>
                <div class="field-wrap">
                    <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m6-14h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2" />
                    </svg>
                    <select id="department_id" name="department_id" class="field-select" required>
                        <option value="">Select</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('department_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="field-group">
            <label class="field-label" for="password">Password</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input id="password" class="field-input" type="password" name="password" required
                    autocomplete="new-password" placeholder="At least 8 characters">
            </div>
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="field-group">
            <label class="field-label" for="password_confirmation">Confirm password</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <input id="password_confirmation" class="field-input" type="password" name="password_confirmation"
                    required autocomplete="new-password" placeholder="Re-enter password">
            </div>
            @error('password_confirmation')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            Create account
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>

    <p class="auth-footer-link">
        Already registered? <a href="{{ route('login') }}">Sign in instead</a>
    </p>

    <script>
        const roleOptions = document.querySelectorAll('.role-option');
        const matricWrapper = document.getElementById('matric-wrapper');

        function syncMatricVisibility() {
            const checked = document.querySelector('input[name="role"]:checked');
            matricWrapper.style.display = checked && checked.value === 'supervisor' ? 'none' : 'block';
        }

        roleOptions.forEach(option => {
            option.addEventListener('click', () => {
                roleOptions.forEach(o => o.classList.remove('active'));
                option.classList.add('active');
                option.querySelector('input').checked = true;
                syncMatricVisibility();
            });
        });

        syncMatricVisibility();
    </script>

</x-guest-layout>
