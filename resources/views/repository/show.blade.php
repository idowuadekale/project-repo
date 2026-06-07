<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Project Detail</h2>
            <a href="{{ route('repository.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to
                Repository</a>
        </div>
    </x-slot>

    <div class="py-8 px-6 max-w-4xl mx-auto space-y-6">

        {{-- Approved badge --}}
        <div class="flex items-center gap-2">
            <span class="bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
                ✓ Approved
            </span>
            <span class="text-sm text-gray-400">{{ $project->department->name ?? '—' }} &bull;
                {{ $project->year }}</span>
        </div>

        {{-- Main card --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-5">

            <h3 class="text-xl font-bold text-gray-800 leading-snug">
                {{ $project->title }}
            </h3>

            {{-- Meta grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm border-t border-b py-4">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Author</p>
                    <p class="font-medium text-gray-800">{{ $project->student->name ?? '—' }}</p>
                    @if ($project->student?->matric_number)
                        <p class="text-xs text-gray-400">{{ $project->student->matric_number }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Supervisor</p>
                    <p class="font-medium text-gray-800">{{ $project->supervisor->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Department</p>
                    <p class="font-medium text-gray-800">{{ $project->department->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Year</p>
                    <p class="font-medium text-gray-800">{{ $project->year }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Submitted</p>
                    <p class="font-medium text-gray-800">{{ $project->created_at->format('d M Y') }}</p>
                </div>
            </div>

            {{-- Keywords --}}
            @if ($project->keywords)
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Keywords</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach (explode(',', $project->keywords) as $keyword)
                            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">
                                {{ trim($keyword) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Abstract --}}
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Abstract</p>
                <p class="text-sm leading-relaxed text-gray-700 bg-gray-50 p-4 rounded-lg">
                    {{ $project->abstract }}
                </p>
            </div>

            {{-- Download button --}}
            <div class="pt-2">
                <a href="{{ route('repository.download', $project) }}"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white
                          px-5 py-2.5 rounded hover:bg-blue-700 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0
                                 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        {{-- Comments (read-only for students, visible to all) --}}
        @if ($project->comments->count())
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="font-semibold text-gray-700 mb-4">
                    Supervisor Notes ({{ $project->comments->count() }})
                </h4>
                @foreach ($project->comments as $comment)
                    <div class="border-b last:border-0 py-3">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800">
                                {{ $comment->user->name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $comment->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $comment->message }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
