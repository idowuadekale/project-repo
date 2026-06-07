<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Review Project</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-4xl mx-auto space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- Status banner --}}
        @if ($project->isApproved())
            <div class="p-4 bg-green-50 border border-green-200 rounded flex justify-between items-center">
                <p class="text-green-700 font-medium">This project is approved.</p>
                <form method="POST" action="{{ route('supervisor.projects.revert', $project) }}">
                    @csrf
                    <button class="text-xs text-gray-500 underline hover:text-gray-700">
                        Revert to pending
                    </button>
                </form>
            </div>
        @elseif($project->isRejected())
            <div class="p-4 bg-red-50 border border-red-200 rounded flex justify-between items-center">
                <div>
                    <p class="text-red-700 font-medium">This project was rejected.</p>
                    @if ($project->rejection_reason)
                        <p class="text-sm text-red-600 mt-1">Reason: {{ $project->rejection_reason }}</p>
                    @endif
                </div>
                <form method="POST" action="{{ route('supervisor.projects.revert', $project) }}">
                    @csrf
                    <button class="text-xs text-gray-500 underline hover:text-gray-700">
                        Revert to pending
                    </button>
                </form>
            </div>
        @else
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-yellow-700 font-medium">Awaiting your review.</p>
            </div>
        @endif

        {{-- Project info --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-5">
            <h3 class="text-lg font-bold text-gray-800">{{ $project->title }}</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Student</p>
                    <p class="font-medium">{{ $project->student->name ?? '—' }}</p>
                    @if ($project->student?->matric_number)
                        <p class="text-xs text-gray-400">{{ $project->student->matric_number }}</p>
                    @endif
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
                    <div class="col-span-2">
                        <p class="text-gray-500">Keywords</p>
                        <p class="font-medium">{{ $project->keywords }}</p>
                    </div>
                @endif
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Abstract</p>
                <p class="text-sm leading-relaxed text-gray-700 bg-gray-50 p-4 rounded">
                    {{ $project->abstract }}
                </p>
            </div>

            {{-- Download PDF --}}
            <div class="pt-2">
                {{-- <a href="{{ route('student.projects.download', $project) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-gray-100 text-gray-700
                          px-4 py-2 rounded hover:bg-gray-200 text-sm">
                    Download PDF
                </a> --}}
                <a href="{{ route('projects.download', $project) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-gray-100 text-gray-700
                          px-4 py-2 rounded hover:bg-gray-200 text-sm">
                    Download PDF
                </a>
            </div>
        </div>

        {{-- Approve / Reject panel (only for pending) --}}
        @if ($project->isPending())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Approve --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="font-semibold text-green-700 mb-3">Approve Project</h4>
                    <p class="text-sm text-gray-500 mb-4">
                        Approving will make this project visible in the repository.
                    </p>
                    <form method="POST" action="{{ route('supervisor.projects.approve', $project) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Approve this project?')"
                            class="w-full bg-green-600 text-white py-2 rounded
                                       hover:bg-green-700 font-medium text-sm">
                            Approve
                        </button>
                    </form>
                </div>

                {{-- Reject --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="font-semibold text-red-600 mb-3">Reject Project</h4>
                    <form method="POST" action="{{ route('supervisor.projects.reject', $project) }}">
                        @csrf
                        @error('rejection_reason')
                            <p class="text-xs text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                        <textarea name="rejection_reason" rows="3" placeholder="Provide a reason for rejection (required)..."
                            class="w-full border-gray-300 rounded text-sm mb-3 shadow-sm" required>{{ old('rejection_reason') }}</textarea>
                        <button type="submit" onclick="return confirm('Reject this project?')"
                            class="w-full bg-red-600 text-white py-2 rounded
                                       hover:bg-red-700 font-medium text-sm">
                            Reject
                        </button>
                    </form>
                </div>

            </div>
        @endif

        {{-- Comments section --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">
                Comments
                @if ($project->comments->count())
                    <span class="text-xs text-gray-400 font-normal ml-1">
                        ({{ $project->comments->count() }})
                    </span>
                @endif
            </h4>

            {{-- Existing comments --}}
            @forelse($project->comments as $comment)
                <div class="border-b last:border-0 py-3">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $comment->message }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-400 mb-4">No comments yet.</p>
            @endforelse

            {{-- Add comment form --}}
            <form method="POST" action="{{ route('supervisor.projects.comment', $project) }}" class="mt-4 space-y-3">
                @csrf
                @error('message')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
                <textarea name="message" rows="3" placeholder="Leave a comment or feedback for the student..."
                    class="w-full border-gray-300 rounded text-sm shadow-sm" required>{{ old('message') }}</textarea>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded
                                   hover:bg-blue-700 text-sm">
                        Post Comment
                    </button>
                </div>
            </form>
        </div>

        {{-- Back link --}}
        <div>
            <a href="{{ route('supervisor.projects.index') }}" class="text-sm text-gray-500 hover:underline">
                &larr; Back to all projects
            </a>
        </div>

    </div>
</x-app-layout>
