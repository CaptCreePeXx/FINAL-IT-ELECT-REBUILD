<div class="p-4">
    <h3 class="text-lg font-semibold mb-4">{{ $patient->name }}'s Completed Appointments</h3>

    @php
        $completedAppointments = $appointments->filter(fn($appt) => $appt->status === 'completed');
    @endphp

    @if($completedAppointments->count())
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Date</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Time</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Service</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Dentist Assigned</th>
                    <!--<th class="px-4 py-2 text-sm font-medium text-gray-600">Notes</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($completedAppointments as $appt)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                    <td class="px-4 py-2">{{ $appt->service_needed ?? ($appt->service->name ?? '-') }}</td>
                    <td class="px-4 py-2">{{ $appt->dentist->name ?? '-' }}</td>
                    <!--<td class="px-4 py-2">{{ $appt->notes ?? '-' }}</td>-->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-sm">No completed appointments found for this patient.</p>
    @endif
</div>