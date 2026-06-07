<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Stats grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Students</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_students'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Supervisors</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_supervisors'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Departments</p>
                <p class="text-3xl font-bold text-gray-600">{{ $stats['total_departments'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-sm text-gray-500">Total Projects</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_projects'] }}</p>
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

        {{-- Quick links --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('admin.users.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                Manage Users
            </a>
            <a href="{{ route('admin.projects.index') }}"
                class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-sm">
                Manage Projects
            </a>
            <a href="{{ route('admin.users.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                + Add User
            </a>
            <a href="{{ route('admin.activity') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                Activity Log
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Recent projects --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-semibold text-gray-700">Recent Projects</h3>
                </div>
                @forelse($recentProjects as $project)
                    <div class="px-6 py-3 border-b last:border-0 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-800 truncate max-w-xs">
                                {{ $project->title }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $project->student->name ?? '—' }} &bull; {{ $project->year }}
                            </p>
                        </div>
                        <span
                            class="px-2 py-1 rounded-full text-xs
                            {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">No projects yet.</p>
                @endforelse
            </div>

            {{-- Recent activity --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-semibold text-gray-700">Recent Activity</h3>
                </div>
                @forelse($recentLogs as $log)
                    <div class="px-6 py-3 border-b last:border-0">
                        <p class="text-sm text-gray-800">
                            <span class="font-medium">{{ $log->user->name ?? 'System' }}</span>
                            {{ $log->action }}
                            @if ($log->subject)
                                &mdash; <span class="italic text-gray-500">{{ $log->subject }}</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">No activity yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
