<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Submit Final Year Project</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student.projects.store') }}" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Project Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Enter full project title" required>
                </div>

                {{-- Abstract --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Abstract <span class="text-gray-400 text-xs">(100–2000 characters)</span>
                    </label>
                    <textarea name="abstract" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Write a concise summary of your project..." required>{{ old('abstract') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1" id="char-count">0 / 2000</p>
                </div>

                {{-- Year + Supervisor side by side --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Year</label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="2000"
                            max="{{ date('Y') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supervisor</label>
                        <select name="supervisor_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="">-- Select Supervisor --</option>
                            @foreach ($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}"
                                    {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Keywords --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Keywords <span class="text-gray-400 text-xs">(optional, comma-separated)</span>
                    </label>
                    <input type="text" name="keywords" value="{{ old('keywords') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="e.g. machine learning, data analysis, Python">
                </div>

                {{-- PDF Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Project File <span class="text-gray-400 text-xs">(PDF only, max 10MB)</span>
                    </label>
                    <input type="file" name="project_file" accept=".pdf"
                        class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4 file:rounded
                                  file:border-0 file:text-sm file:font-medium
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100"
                        required>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('student.dashboard') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Submit Project
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const abstract = document.querySelector('textarea[name="abstract"]');
        const charCount = document.getElementById('char-count');
        abstract.addEventListener('input', () => {
            charCount.textContent = abstract.value.length + ' / 2000';
        });
    </script>
</x-app-layout>
