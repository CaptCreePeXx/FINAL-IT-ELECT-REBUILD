<div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
    <table class="min-w-full border-collapse text-left">
        <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
            <tr>
                <th class="px-4 py-2 border-r border-gray-300">Date & Time</th>
                <th class="px-4 py-2 border-r border-gray-300">Service</th>
                <th class="px-4 py-2 border-r border-gray-300">Cancellation Reason</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody class="bg-gray-50">
            @forelse($list as $appointment)
            <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                <td class="py-2 px-4 border-r border-gray-200">
                    {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                    — {{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}
                </td>
                <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->service->name ?? 'Unknown Service' }}</td>
                <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->cancellation_reason ?? 'No reason provided' }}</td>
                <td class="py-2 px-4">
                    @if($appointment->status == 'cancellation_requested')
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @elseif($appointment->status == 'cancelled')
                        <span class="text-green-600 font-semibold">Approved</span>
                    @else
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">No cancellation requests</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
