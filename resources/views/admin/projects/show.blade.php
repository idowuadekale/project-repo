<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Project Detail — Admin View</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-4xl mx-auto space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- Project info --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div class="flex justify-between items-start">
                <h3 class="text-lg font-bold text-gray-800">{{ $project->title }}</h3>
                <span
                    class="px-3 py-1 rounded-full text-xs font-medium
                    {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Student</p>
                    <p class="font-medium">{{ $project->student->name ?? '—' }}</p>
                    <p class="text-xs text-gray-400">{{ $project->student->matric_number ?? '' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Supervisor</p>
                    <p class="font-medium">{{ $project->supervisor->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Department</p>
                    <p class="font-medium">{{ $project->department->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Year</p>
                    <p class="font-medium">{{ $project->year }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Submitted</p>
                    <p class="font-medium">{{ $project->created_at->format('d M Y') }}</p>
                </div>
                @if ($project->keywords)
                    <div>
                        <p class="text-gray-500">Keywords</p>
                        <p class="font-medium">{{ $project->keywords }}</p>
                    </div>
                @endif
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Abstract</p>
                <p class="text-sm leading-relaxed bg-gray-50 p-4 rounded text-gray-700">
                    {{ $project->abstract }}
                </p>
            </div>

            @if ($project->rejection_reason)
                <div class="p-3 bg-red-50 rounded text-sm text-red-700">
                    <strong>Rejection reason:</strong> {{ $project->rejection_reason }}
                </div>
            @endif

            <a href="{{ route('admin.projects.download', $project) }}"
                class="inline-block bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">
                Download PDF
            </a>
        </div>

        {{-- Admin actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Approve --}}
            @if (!$project->isApproved())
                <div class="bg-white rounded-lg shadow p-5">
                    <h4 class="font-semibold text-green-700 mb-3">Approve Project</h4>
                    <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                        @csrf
                        <button onclick="return confirm('Approve this project?')"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 text-sm">
                            Approve
                        </button>
                    </form>
                </div>
            @endif

            {{-- Reject --}}
            @if (!$project->isRejected())
                <div class="bg-white rounded-lg shadow p-5">
                    <h4 class="font-semibold text-red-600 mb-3">Reject Project</h4>
                    <form method="POST" action="{{ route('admin.projects.reject', $project) }}">
                        @csrf
                        @error('rejection_reason')
                            <p class="text-xs text-red-600 mb-1">{{ $message }}</p>
                        @enderror
                        <textarea name="rejection_reason" rows="2" required placeholder="Reason for rejection..."
                            class="w-full border-gray-300 rounded text-sm mb-3 shadow-sm">{{ old('rejection_reason') }}</textarea>
                        <button onclick="return confirm('Reject this project?')"
                            class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 text-sm">
                            Reject
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- Reassign supervisor --}}
        <div class="bg-white rounded-lg shadow p-5">
            <h4 class="font-semibold text-gray-700 mb-3">Reassign Supervisor</h4>
            <form method="POST" action="{{ route('admin.projects.supervisor', $project) }}" class="flex gap-3">
                @csrf
                <select name="supervisor_id" class="flex-1 border-gray-300 rounded shadow-sm text-sm">
                    <option value="">-- Select Supervisor --</option>
                    @foreach ($supervisors as $sup)
                        <option value="{{ $sup->id }}"
                            {{ $project->supervisor_id == $sup->id ? 'selected' : '' }}>
                            {{ $sup->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm">
                    Reassign
                </button>
            </form>
        </div>

        {{-- Comments --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">Comments ({{ $project->comments->count() }})</h4>
            @forelse($project->comments as $comment)
                <div class="border-b last:border-0 py-3">
                    <div class="flex justify-between">
                        <p class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $comment->message }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-400">No comments.</p>
            @endforelse
        </div>

        <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to
            projects</a>

    </div>
</x-app-layout>
