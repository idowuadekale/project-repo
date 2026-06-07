<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Assigned Projects</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Status filter --}}
        <div class="mb-6 flex gap-2 flex-wrap">
            @foreach (['all', 'pending', 'approved', 'rejected'] as $filter)
                <a href="{{ $filter === 'all' ? route('supervisor.projects.index') : route('supervisor.projects.index', ['status' => $filter]) }}"
                    class="px-4 py-1.5 rounded-full text-sm border
                       {{ request('status') === $filter || ($filter === 'all' && !request('status'))
                           ? 'bg-blue-600 text-white border-blue-600'
                           : 'text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                    {{ ucfirst($filter) }}
                </a>
            @endforeach
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr class="{{ $project->isPending() ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 max-w-xs truncate">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->student->name ?? '—' }}
                                @if ($project->student?->matric_number)
                                    <span
                                        class="text-gray-400 text-xs block">{{ $project->student->matric_number }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->year }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $project->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $project->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('supervisor.projects.show', $project) }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    {{ $project->isPending() ? 'Review' : 'View' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
