<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" required
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                            @foreach (['student', 'supervisor', 'admin'] as $r)
                                <option value="{{ $r }}"
                                    {{ old('role', $user->role) === $r ? 'selected' : '' }}>
                                    {{ ucfirst($r) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Department</label>
                        <select name="department_id"
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                            <option value="">-- Select --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Matric Number</label>
                    <input type="text" name="matric_number" value="{{ old('matric_number', $user->matric_number) }}"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            New Password <span class="text-gray-400 text-xs">(leave blank to keep)</span>
                        </label>
                        <input type="password" name="password"
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm text-sm">
                    </div>
                </div>

                <div class="flex justify-between pt-2">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 text-sm">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
