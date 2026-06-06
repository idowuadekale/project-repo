<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Supervisor Dashboard</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Total Assigned</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Approved</p>
                <p class="text-3xl font-bold text-green-500">{{ $stats['approved'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Rejected</p>
                <p class="text-3xl font-bold text-red-500">{{ $stats['rejected'] }}</p>
            </div>
        </div>

        {{-- Quick action --}}
        <div class="mb-6">
            <a href="{{ route('supervisor.projects.index') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm">
                View All Assigned Projects
            </a>
        </div>

        {{-- Recent projects --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-700">Recent Submissions</h3>
                @if ($stats['pending'] > 0)
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">
                        {{ $stats['pending'] }} need review
                    </span>
                @endif
            </div>
            @forelse($recentProjects as $project)
                <div class="px-6 py-4 border-b last:border-0 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">{{ $project->title }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $project->student->name ?? '—' }} &bull;
                            {{ $project->year }} &bull;
                            {{ $project->department->name ?? '—' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                        <a href="{{ route('supervisor.projects.show', $project) }}"
                            class="text-blue-600 text-sm hover:underline">Review</a>
                    </div>
                </div>
            @empty
                <p class="px-6 py-4 text-gray-400 text-sm">No projects assigned yet.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
