<div class="bg-white rounded-xl shadow-md card-border p-4">
  <div class="flex items-center justify-between mb-3">
    <h3 class="font-semibold">Upcoming Appointments</h3>
    <a href="{{ route('appointments.create') }}" class="px-3 py-1 rounded text-sm bg-[color:var(--clr-2)] text-[color:var(--clr-1)]">Book Appointment</a>
  </div>

  @if($appointments->isEmpty())
    <div class="text-sm text-gray-500">No upcoming appointments.</div>
  @else
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="text-xs text-gray-500">
          <tr>
            <th class="py-2">Date</th>
            <th class="py-2">Time</th>
            <th class="py-2">Dentist</th>
            <th class="py-2">Service</th>
            <th class="py-2">Status</th>
            <th class="py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($appointments as $appt)
            <tr class="border-t">
              <td class="py-2">{{ $appt->date }}</td>
              <td class="py-2">{{ \Illuminate\Support\Str::limit($appt->time, 5) }}</td>
              <td class="py-2">{{ $appt->dentist?->name ?? '—' }}</td>
              <td class="py-2">{{ $appt->service?->name ?? '—' }}</td>
              <td class="py-2 capitalize">{{ $appt->status ?? 'pending' }}</td>
              <td class="py-2">
                <a href="{{ route('appointments.show', $appt->id) }}" class="text-sm text-[color:var(--clr-1)] underline">View</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
