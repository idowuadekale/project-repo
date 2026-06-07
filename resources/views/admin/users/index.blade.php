<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- Filters --}}
        <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Name, email or matric no..." class="border-gray-300 rounded shadow-sm text-sm w-64">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Role</label>
                <select name="role" class="border-gray-300 rounded shadow-sm text-sm">
                    <option value="">All roles</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="supervisor" {{ request('role') === 'supervisor' ? 'selected' : '' }}>Supervisor
                    </option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded text-sm hover:bg-gray-800">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">Clear</a>
            <a href="{{ route('admin.users.create') }}"
                class="ml-auto bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                + Add User
            </a>
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matric No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $user->role === 'supervisor' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $user->role === 'student' ? 'bg-blue-100 text-blue-700' : '' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->department->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->matric_number ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm flex gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">{{ $users->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
