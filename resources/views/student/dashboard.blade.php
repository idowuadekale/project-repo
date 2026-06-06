<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Student Dashboard</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- Stats cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Total</p>
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

        {{-- Quick actions --}}
        <div class="flex gap-4 mb-8">
            <a href="{{ route('student.projects.create') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                + Submit New Project
            </a>
            <a href="{{ route('student.projects.index') }}"
                class="bg-gray-100 text-gray-700 px-5 py-2 rounded hover:bg-gray-200">
                My Submissions
            </a>
        </div>

        {{-- Recent submissions --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-700">Recent Submissions</h3>
            </div>
            @forelse($projects as $project)
                <div class="px-6 py-4 border-b last:border-0 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">{{ $project->title }}</p>
                        <p class="text-sm text-gray-500">{{ $project->year }} &bull;
                            {{ $project->department->name ?? '—' }}</p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
            @empty
                <p class="px-6 py-4 text-gray-500 text-sm">No submissions yet.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
