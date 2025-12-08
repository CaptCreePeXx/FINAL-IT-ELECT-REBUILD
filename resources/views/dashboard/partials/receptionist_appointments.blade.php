@if($list->isEmpty())
    <p class="text-gray-600">No appointments found.</p>
@else
    <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                    <th class="px-4 py-2 border-r border-gray-300">Date</th>
                    <th class="px-4 py-2 border-r border-gray-300">Time</th>
                    <th class="px-4 py-2 border-r border-gray-300">Status</th>
                    <th class="px-4 py-2 border-r border-gray-300">Note</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($list as $appointment)
                <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                    <td class="py-2 px-4 border-r border-gray-200 capitalize">{{ str_replace('_', ' ', $appointment->status) }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->cancellation_reason ?? '-' }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        @if($appointment->status === 'pending')
                            <form action="{{ route('receptionist.appointments.approve', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Approve</button>
                            </form>
                            <form action="{{ route('receptionist.appointments.decline', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Decline</button>
                            </form>
                        @elseif($appointment->status === 'approved')
                            <form action="{{ route('receptionist.appointments.complete', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">Complete</button>
                            </form>
                            <form action="{{ route('receptionist.appointments.decline', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Decline</button>
                            </form>
                        @elseif($appointment->status === 'cancellation_requested')
                            <form action="{{ route('receptionist.appointments.cancel.approve', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">Approve</button>
                            </form>
                            <form action="{{ route('receptionist.appointments.cancel.reject', $appointment) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
