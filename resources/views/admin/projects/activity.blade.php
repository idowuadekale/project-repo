<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Activity Log</h2>
    </x-slot>

    <div class="py-8 px-6 max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">
                                {{ $log->user->name ?? 'System' }}
                                <span class="text-xs text-gray-400 block">
                                    {{ $log->user->role ?? '' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $log->action }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500 italic">{{ $log->subject ?? '—' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-400">{{ $log->ip_address ?? '—' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-400">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-400 text-sm">
                                No activity recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>
