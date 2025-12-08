@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('sidebar')
    @include('dashboard.partials.receptionist_sidebar')
@endsection

@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ $user->name }}</h2>

@if(session('success'))
<div id="flash-message" class="mb-4 p-3 bg-green-600 text-white rounded shadow">
    {{ session('success') }}
</div>
@endif

<!-- Quick Stats Cards -->
<div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 mb-16">
    <div class="p-4 bg-blue-50 rounded shadow text-center">
        <p class="text-gray-600 text-sm">Approved</p>
        <p class="font-bold text-xl">{{ $stats['approved'] }}</p>
    </div>
    <div class="p-4 bg-green-50 rounded shadow text-center">
        <p class="text-gray-600 text-sm">Completed</p>
        <p class="font-bold text-xl">{{ $stats['completed'] }}</p>
    </div>
    <div class="p-4 bg-yellow-50 rounded shadow text-center">
        <p class="text-gray-600 text-sm">Total Appointments</p>
        <p class="font-bold text-xl">{{ $stats['total'] }}</p>
    </div>
    <div class="p-4 bg-red-50 rounded shadow text-center">
        <p class="text-gray-600 text-sm">Patients</p>
        <p class="font-bold text-xl">{{ $stats['patients'] }}</p>
    </div>
</div>

<!-- TAB CONTENTS -->
<div id="tab-contents">

    <!-- Dashboard Overview -->
    <div class="tab-content" id="dashboard">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Pending Appointments -->
<div class="p-4 md:p-0">
    <h3 class="text-lg font-semibold mb-2">Pending Appointments</h3>
    @if($pending->count())
    <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                    <th class="px-4 py-2 border-r border-gray-300">Date</th>
                    <th class="px-4 py-2 border-r border-gray-300">Time</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($pending as $appointment)
                <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                    <td class="py-2 px-4 flex gap-1">
                        <form method="POST" action="{{ route('receptionist.appointments.approve', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('receptionist.appointments.decline', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Decline</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-sm">No pending appointments.</p>
    @endif
</div>

<!-- Approved Appointments -->
<div class="p-4 md:p-0">
    <h3 class="text-lg font-semibold mb-2">Approved Appointments</h3>
    @if($approved->count())
    <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                    <th class="px-4 py-2 border-r border-gray-300">Date</th>
                    <th class="px-4 py-2 border-r border-gray-300">Time</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($approved as $appointment)
                <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                    <td class="py-2 px-4 flex gap-1">
                        <form method="POST" action="{{ route('receptionist.appointments.complete', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Complete</button>
                        </form>
                        <form method="POST" action="{{ route('receptionist.appointments.decline', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Decline</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-sm">No approved appointments.</p>
    @endif
</div>

<!-- Cancellation Requests -->
<div class="p-4 md:p-0 md:col-span-2">
    <h3 class="text-lg font-semibold mb-2">Cancellation Requests</h3>
    @if($cancellations->count())
    <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                    <th class="px-4 py-2 border-r border-gray-300">Date</th>
                    <th class="px-4 py-2 border-r border-gray-300">Time</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($cancellations as $appointment)
                <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                    <td class="py-2 px-4 flex gap-1">
                        <form method="POST" action="{{ route('receptionist.appointments.cancel.approve', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('receptionist.appointments.cancel.reject', $appointment) }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-sm">No cancellation requests.</p>
    @endif
</div>


</div>


 
    </div>

    <!-- Appointments Tab -->
    <div class="tab-content hidden" id="appointments">
        <h3 class="text-lg font-semibold mb-2">All Appointments</h3>
        @include('dashboard.partials.receptionist_appointments', ['list' => $allAppointments])
    </div>

    <div id="profile" class="tab-content hidden">
    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')
    @include('profile.partials.delete-user-form')
</div>

    <!-- Patients Tab -->
    <div class="tab-content hidden" id="patients">
        <form method="GET" action="{{ route('receptionist.dashboard') }}" class="mb-4 flex gap-2">
    <input type="hidden" name="tab" value="patients">
    <input type="text" name="search" placeholder="Search patient name..."
        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
        value="{{ request('search') }}">
    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
</form>


        @if($patients->count())
        <div class="space-y-2">
            @foreach($patients as $patient)
            <div class="p-4 bg-white rounded shadow border flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $patient->name }}</p>
                    <p class="text-gray-600">{{ $patient->email }}</p>
                </div>
                <button onclick="openModal({{ $patient->id }})" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">View History</button>

                <!-- Modal -->
                <div id="modal-{{ $patient->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="relative w-11/12 md:w-1/2">
                        <button onclick="closeModal({{ $patient->id }})"
                                class="absolute -top-4 -right-4 w-10 h-10 flex items-center justify-center text-2xl font-bold rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-900 shadow-lg">
                            &times;
                        </button>

                        <div class="bg-white rounded shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-3">History for {{ $patient->name }}</h3>

                            @php
                                $history = \App\Models\Appointment::with(['service', 'dentist'])
                                            ->where('patient_id', $patient->id)
                                            ->whereIn('status', ['approved', 'completed'])
                                            ->orderByDesc('date')
                                            ->get();
                            @endphp

                            @if($history->count())
                            <ul class="space-y-2 text-sm">
                                @foreach($history as $record)
                                <li>
                                    <strong>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }} {{ \Carbon\Carbon::parse($record->time)->format('h:i A') }}:</strong>
                                    {{ $record->service->name ?? 'Unknown Service' }} with {{ $record->dentist->name ?? 'Unknown Dentist' }}
                                    ({{ $record->status }})
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-gray-500">No approved or completed history found.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Reports Tab -->
    <div class="tab-content hidden" id="reports">
        <h3 class="text-lg font-semibold mb-2">Reports</h3>
        <p class="text-gray-600">Coming soon: generate daily, weekly, and monthly appointment reports here.</p>
    </div>

</div>

@push('scripts')
<script>
const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => {
            t.classList.remove('active', 'text-blue-600', 'border-blue-600', 'font-semibold');
            t.classList.add('text-gray-600');
        });
        tab.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600', 'font-semibold');
        contents.forEach(c => c.classList.add('hidden'));
        document.getElementById(tab.dataset.tab).classList.remove('hidden');
    });
});

function switchTab(tabId) {
    const targetTab = document.querySelector(`[data-tab="${tabId}"]`);
    if(targetTab) targetTab.click();
}

function openModal(id) {
    const modal = document.getElementById(`modal-${id}`);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(`modal-${id}`);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || 'dashboard';
    switchTab(tab);
});

function openTab(tabId) {
    const tabs = ['dashboard', 'appointments', 'patients', 'reports', 'profile']; // add profile

    tabs.forEach(id => {
        const el = document.getElementById('sidebar-' + id);
        if(el) {
            if(id === tabId) {
                el.classList.add('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
            } else {
                el.classList.remove('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
            }
        }
    });

    // Show tab content
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    const content = document.getElementById(tabId);
    if(content) content.classList.remove('hidden');
}

</script>
@endpush

@endsection
