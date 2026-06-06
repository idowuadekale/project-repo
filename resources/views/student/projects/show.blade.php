<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Project Details</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-3xl mx-auto space-y-6">

        {{-- Status banner --}}
        @if ($project->isRejected())
            <div class="p-4 bg-red-50 border border-red-200 rounded">
                <p class="font-medium text-red-700">This project was rejected.</p>
                @if ($project->rejection_reason)
                    <p class="text-sm text-red-600 mt-1">Reason: {{ $project->rejection_reason }}</p>
                @endif
            </div>
        @elseif($project->isApproved())
            <div class="p-4 bg-green-50 border border-green-200 rounded">
                <p class="font-medium text-green-700">This project has been approved.</p>
            </div>
        @else
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="font-medium text-yellow-700">Awaiting review.</p>
            </div>
        @endif

        {{-- Project details card --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-bold text-gray-800">{{ $project->title }}</h3>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Year</p>
                    <p class="font-medium">{{ $project->year }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Department</p>
                    <p class="font-medium">{{ $project->department->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Supervisor</p>
                    <p class="font-medium">{{ $project->supervisor->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Submitted</p>
                    <p class="font-medium">{{ $project->created_at->format('d M Y') }}</p>
                </div>
            </div>

            @if ($project->keywords)
                <div>
                    <p class="text-gray-500 text-sm">Keywords</p>
                    <p class="text-sm">{{ $project->keywords }}</p>
                </div>
            @endif

            <div>
                <p class="text-gray-500 text-sm mb-1">Abstract</p>
                <p class="text-sm leading-relaxed text-gray-700">{{ $project->abstract }}</p>
            </div>

            <div class="pt-2">
                <a href="{{ route('student.projects.download', $project) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                    Download PDF
                </a>
                <a href="{{ route('student.projects.index') }}" class="ml-3 text-sm text-gray-500 hover:underline">Back
                    to list</a>
            </div>
        </div>

        {{-- Comments from supervisor --}}
        @if ($project->comments->count())
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="font-semibold text-gray-700 mb-4">Supervisor Comments</h4>
                @foreach ($project->comments as $comment)
                    <div class="border-b last:border-0 py-3">
                        <p class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $comment->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
