<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Submissions</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="mb-4 flex justify-end">
            <a href="{{ route('student.projects.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                + New Submission
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supervisor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 max-w-xs truncate">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->year }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->supervisor->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('student.projects.show', $project) }}"
                                    class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('student.projects.download', $project) }}"
                                    class="text-gray-500 hover:underline">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No submissions yet.
                                <a href="{{ route('student.projects.create') }}"
                                    class="text-blue-600 hover:underline">Submit your first project</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
