@if($list->count() == 0)
    <p class="text-gray-500">No appointments found.</p>
@else
    <div class="max-h-80 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-3 py-2 border-r border-gray-300">Date</th>
                    <th class="px-3 py-2 border-r border-gray-300">Time</th>
                    <th class="px-3 py-2 border-r border-gray-300">Service</th>
                    <th class="px-3 py-2 border-r border-gray-300">Dentist</th>
                    <th class="px-3 py-2 border-r border-gray-300">Status</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($list as $appt)
                <tr class="hover:bg-gray-100 border-b border-gray-200">
                    <td class="px-3 py-2 border-r border-gray-200">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                    <td class="px-3 py-2 border-r border-gray-200">{{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</td>
                    <td class="px-3 py-2 border-r border-gray-200">{{ $appt->service->name ?? 'Unknown Service' }}</td>
                    <td class="px-3 py-2 border-r border-gray-200">{{ $appt->dentist->name ?? 'Unknown Dentist' }}</td>
                    <td class="px-3 py-2 border-r border-gray-200 capitalize font-semibold">{{ $appt->status }}</td>
                    <td class="px-3 py-2">
                        @if($appt->status === 'pending')
                            <form action="{{ route('appointments.cancelPending', $appt->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to cancel this pending appointment?');">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Cancel
                                </button>
                            </form>
                        @elseif($appt->status === 'approved')
                            <form action="{{ route('appointments.requestCancellation', $appt->id) }}" method="POST"
                                  onsubmit="return promptCancellationReason(this);">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Request Cancellation
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<script>
function promptCancellationReason(form) {
    let reason = prompt("Please enter a reason for cancellation:");
    if (!reason) {
        return false; // cancel submission if empty
    }

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "reason";
    input.value = reason;
    form.appendChild(input);
    return true;
}
</script>
