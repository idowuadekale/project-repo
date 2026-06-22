<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Project Repository</h2>
            <span class="text-sm text-gray-500">{{ $total }} approved project{{ $total != 1 ? 's' : '' }}</span>
        </div>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        {{-- Search & Filter bar --}}
        <form method="GET" action="{{ route('repository.index') }}" class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-xs text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by title, keyword or abstract..."
                        class="w-full border-gray-300 rounded shadow-sm text-sm">
                </div>

                {{-- Department --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Department</label>
                    <select name="department" class="w-full border-gray-300 rounded shadow-sm text-sm">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Year --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Year</label>
                    <select name="year" class="w-full border-gray-300 rounded shadow-sm text-sm">
                        <option value="">All Years</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="flex items-center gap-3 mt-3">
                {{-- Sort --}}
                <select name="sort" class="border-gray-300 rounded shadow-sm text-sm">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest first</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                    <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title A–Z</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded text-sm hover:bg-blue-700">
                    Search
                </button>

                @if (request()->hasAny(['search', 'department', 'year', 'sort']))
                    <a href="{{ route('repository.index') }}" class="text-sm text-gray-500 hover:underline">Clear
                        filters</a>
                @endif
            </div>
        </form>

        {{-- Results --}}
        @if ($projects->isEmpty())
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-gray-400 text-lg mb-2">No projects found.</p>
                <p class="text-gray-400 text-sm">Try adjusting your search or filters.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                @foreach ($projects as $project)
                    <div
                        class="bg-white rounded-lg shadow hover:shadow-md
                                transition-shadow duration-200 flex flex-col">
                        <div class="p-5 flex-1">

                            {{-- Department + Year badge --}}
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="text-xs bg-blue-50 text-blue-700
                                             px-2 py-1 rounded-full">
                                    {{ $project->department->name ?? '—' }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $project->year }}</span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-semibold text-gray-800 text-sm mb-2 leading-snug">
                                {{ $project->title }}
                            </h3>

                            {{-- Abstract preview --}}
                            <p class="text-xs text-gray-500 leading-relaxed mb-3">
                                {{ Str::limit($project->abstract, 120) }}
                            </p>

                            {{-- Keywords --}}
                            @if ($project->keywords)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach (explode(',', $project->keywords) as $keyword)
                                        <span
                                            class="text-xs bg-gray-100 text-gray-600
                                                     px-2 py-0.5 rounded-full">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Card footer --}}
                        <div
                            class="px-5 py-3 border-t bg-gray-50 rounded-b-lg
                                    flex justify-between items-center">
                            <div class="text-xs text-gray-500">
                                <span class="font-medium text-gray-700">
                                    By: {{ $project->student->name ?? '—' }}
                                </span>
                                @if ($project->supervisor)
                                    <span class="block text-gray-400">
                                        Supervisor: {{ $project->supervisor->name }}
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('repository.show', $project) }}"
                                class="text-xs bg-blue-600 text-white px-3 py-1.5
                                      rounded hover:bg-blue-700">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
