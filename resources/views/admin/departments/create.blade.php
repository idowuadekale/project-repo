<x-app-layout>
    <x-slot name="header">Add Department</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Add Department</h1>
            <p class="page-sub">Create a new academic department</p>
        </div>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <div style="max-width:560px;">
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

                <form method="POST" action="{{ route('admin.departments.store') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Department Name *</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m6-14h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2" />
                            </svg>
                            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required
                                autofocus placeholder="e.g. Computer Science Education">
                        </div>
                        <p class="form-hint">Must be unique across all departments.</p>
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
                            <textarea name="description" class="form-textarea" rows="3" style="padding-left:38px;"
                                placeholder="Brief description of this department...">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="previewBox"
                        style="display:none;background:var(--surface2);
                                border:1px solid var(--border);border-radius:10px;
                                padding:16px;margin-bottom:20px;">
                        <div
                            style="font-size:11px;font-weight:700;text-transform:uppercase;
                                    letter-spacing:0.08em;color:var(--gold);margin-bottom:8px;">
                            Preview
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div
                                style="width:40px;height:40px;border-radius:10px;
                                        background:linear-gradient(135deg,var(--navy),var(--navy2));
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:18px;">
                                🏛</div>
                            <div>
                                <div id="previewName" style="font-weight:700;font-size:14px;color:var(--text);">
                                </div>
                                <div id="previewDesc" style="font-size:12px;color:var(--text4);margin-top:2px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        style="display:flex;justify-content:space-between;
                                align-items:center;padding-top:8px;">
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            Create Department
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Quick tip card --}}
        <div class="card" style="margin-top:16px;border-color:rgba(201,168,76,0.3);">
            <div class="card-body" style="padding:16px 20px;">
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <span style="font-size:20px;flex-shrink:0;">💡</span>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:4px;">
                            Adding departments
                        </div>
                        <div style="font-size:12.5px;color:var(--text3);line-height:1.6;">
                            Once created, the department will immediately appear in the registration
                            form for students and supervisors, and in all search filters
                            across the system. There is no limit on the number of departments
                            you can add.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const nameInput = document.querySelector('input[name="name"]');
        const descInput = document.querySelector('textarea[name="description"]');
        const previewBox = document.getElementById('previewBox');
        const previewName = document.getElementById('previewName');
        const previewDesc = document.getElementById('previewDesc');

        function updatePreview() {
            const name = nameInput.value.trim();
            const desc = descInput.value.trim();
            if (name) {
                previewBox.style.display = 'block';
                previewName.textContent = name;
                previewDesc.textContent = desc || 'No description provided.';
            } else {
                previewBox.style.display = 'none';
            }
        }

        nameInput.addEventListener('input', updatePreview);
        descInput.addEventListener('input', updatePreview);
    </script>

</x-app-layout>
