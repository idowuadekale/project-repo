<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Projects</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Filters --}}
        <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or keywords..."
                    class="border-gray-300 rounded shadow-sm text-sm w-56">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="border-gray-300 rounded shadow-sm text-sm">
                    <option value="">All</option>
                    @foreach (['pending', 'approved', 'rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Year</label>
                <select name="year" class="border-gray-300 rounded shadow-sm text-sm">
                    <option value="">All years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded text-sm hover:bg-gray-800">
                Filter
            </button>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500 hover:underline">Clear</a>
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supervisor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 max-w-xs truncate">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->student->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->supervisor->name ?? '—' }}</td>
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
                            <td class="px-6 py-4 text-sm flex gap-3">
                                <a href="{{ route('admin.projects.show', $project) }}"
                                    class="text-blue-600 hover:underline">View</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                    onsubmit="return confirm('Delete this project and its file?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">{{ $projects->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
