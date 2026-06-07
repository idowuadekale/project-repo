<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Reports & Statistics</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-7xl mx-auto space-y-8">

        {{-- Overall stats --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_projects'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Total Projects</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Approved</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Pending</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-red-500">{{ $stats['rejected'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Rejected</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_students'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Students</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100">
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_supervisors'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Supervisors</p>
            </div>
        </div>

        {{-- By Department --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-700">Projects by Department</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Approved</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pending</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rejected</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($byDepartment as $dept)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $dept->name }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $dept->projects_count }}</td>
                            <td class="px-6 py-4 text-sm text-center text-green-600 font-medium">
                                {{ $dept->approved_count }}</td>
                            <td class="px-6 py-4 text-sm text-center text-yellow-600 font-medium">
                                {{ $dept->pending_count }}</td>
                            <td class="px-6 py-4 text-sm text-center text-red-500 font-medium">
                                {{ $dept->rejected_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No data yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- By Year --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-700">Projects by Year</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Approved</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pending</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rejected</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($byYear as $row)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $row->year }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $row->total }}</td>
                            <td class="px-6 py-4 text-sm text-center text-green-600 font-medium">{{ $row->approved }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-yellow-600 font-medium">{{ $row->pending }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-red-500 font-medium">{{ $row->rejected }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No data yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
