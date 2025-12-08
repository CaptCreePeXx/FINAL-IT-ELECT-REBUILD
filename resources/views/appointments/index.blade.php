@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-900 text-yellow-300 min-h-screen">

    <h1 class="text-2xl font-bold mb-6">All Appointments</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-gray-800 rounded-md shadow-md">
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-yellow-300 border-b border-gray-700">
                    <th class="p-3">Patient</th>
                    <th class="p-3">Dentist</th>
                    <th class="p-3">Service</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Time</th>
                    <th class="p-3">Status</th>
                    @if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2)
                        <th class="p-3">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition-all">
                        <td class="p-3">{{ $appointment->patient->name }}</td>
                        <td class="p-3">{{ $appointment->dentist->name }}</td>
                        <td class="p-3">{{ $appointment->service->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                        <td class="p-3 capitalize">
                            @if($appointment->status == 'approved')
                                <span class="text-green-400 font-semibold">Approved</span>
                            @elseif($appointment->status == 'pending')
                                <span class="text-yellow-400 font-semibold">Pending</span>
                            @else
                                <span class="text-red-400 font-semibold">{{ $appointment->status }}</span>
                            @endif
                        </td>
                        @if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2)
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('appointments.edit', $appointment) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-400">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('appointments.create') }}" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition-all">
            Book New Appointment
        </a>
    </div>
</div>
@endsection
