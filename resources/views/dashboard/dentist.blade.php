@extends('layouts.app')

@section('title', 'Dentist Dashboard')

@section('sidebar')
<aside class="w-64 min-h-screen bg-[#2F3E3C] text-[#FBF9F1] shadow-2xl border-r border-[#C7E7EC] flex flex-col py-6">
    <div class="px-6 mb-6">
        <h1 class="text-xl font-bold tracking-wide">Dentist Panel</h1>
        <div class="mt-1 w-12 h-1 bg-[#C7E7EC] rounded"></div>
    </div>

    <nav class="flex-1 flex flex-col gap-1 px-3">
        <button onclick="openTab('dashboard');" id="sidebar-dashboard"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent">
            <span class="material-icons text-lg">dashboard</span>
            Dashboard
        </button>

        <button onclick="openTab('patients');" id="sidebar-patients"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent hover:bg-[#C7E7EC] hover:text-[#2F3E3C]">
            <span class="material-icons text-lg">groups</span>
            Patients
        </button>

        <button onclick="openTab('profile');" id="sidebar-profile"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent hover:bg-[#C7E7EC] hover:text-[#2F3E3C]">
            <span class="material-icons text-lg">person</span>
            Profile
        </button>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="px-3 mt-auto mb-3">
        @csrf
        <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left 
                       bg-[#2F3E3C] text-[#FBF9F1] border border-transparent
                       hover:bg-[#BDDBD1] hover:text-[#2F3E3C] hover:border-[#C7E7EC] transition-all">
            <span class="material-icons text-lg">logout</span>
            Logout
        </button>
    </form>
</aside>
@endsection

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ $dentist->name }}</h2>

    @if(session('status') === 'profile-updated')
        <div id="flash-message" class="mb-4 p-3 bg-green-600 text-white rounded shadow">
            Profile updated successfully.
        </div>
    @endif

    <!-- Dashboard Tab -->
<div id="dashboard" class="tab-content">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-blue-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Upcoming Appointments</p>
            <p class="font-bold text-xl">{{ $stats['upcoming'] }}</p>
        </div>
        <div class="p-4 bg-green-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Completed Appointments</p>
            <p class="font-bold text-xl">{{ $stats['completed'] }}</p>
        </div>
        <div class="p-4 bg-yellow-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Total Appointments</p>
            <p class="font-bold text-xl">{{ $stats['total'] }}</p>
        </div>
    </div>

    @php
    $upcomingAppointments = $appointments->filter(fn($appt) => $appt->status === 'approved' && \Carbon\Carbon::parse($appt->date)->gte(now()->startOfDay()));
    $todayAppointments = $upcomingAppointments->filter(fn($appt) => \Carbon\Carbon::parse($appt->date)->isToday());
    $morningAppointments = $upcomingAppointments->filter(fn($appt) => \Carbon\Carbon::parse($appt->time)->hour < 12);
    $afternoonAppointments = $upcomingAppointments->filter(fn($appt) => \Carbon\Carbon::parse($appt->time)->hour >= 12);
    @endphp 

<!-- Today's Appointments -->
<div class="p-4 bg-gray-50 rounded-lg shadow border mb-6">
    <h3 class="text-lg font-semibold mb-4">Today's Appointments ({{ $todayAppointments->count() }})</h3>

    @if($todayAppointments->count())
    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 border-b border-gray-300 sticky top-0">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Patient</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Time</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($todayAppointments as $appt)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $appt->patient->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($appt->status === 'pending') bg-yellow-100 text-yellow-800 @endif
                            @if($appt->status === 'completed') bg-green-100 text-green-800 @endif
                            @if($appt->status === 'canceled') bg-red-100 text-red-800 @endif">
                            {{ ucfirst($appt->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        @if($appt->patient)
                        <button onclick="openPatientModal({{ $appt->patient->id }})"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            View History
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-sm">No appointments today.</p>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- Morning Session -->
    <div class="p-4 bg-gray-50 rounded-lg shadow border">
        <h3 class="text-lg font-semibold mb-4">Morning Session</h3>

        @if($morningAppointments->count())
        <div class="overflow-x-auto border border-gray-300 rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200 border-b border-gray-300 sticky top-0">
                    <tr>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Patient</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Date</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Time</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Status</th>
                        <th class="px-4 py-2 text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @foreach($morningAppointments as $appt)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $appt->patient->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($appt->status === 'pending') bg-yellow-100 text-yellow-800 @endif
                                @if($appt->status === 'completed') bg-green-100 text-green-800 @endif
                                @if($appt->status === 'canceled') bg-red-100 text-red-800 @endif">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if($appt->patient)
                            <button onclick="openPatientModal({{ $appt->patient->id }})"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                View History
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-sm">No morning appointments.</p>
        @endif
    </div>

    <!-- Afternoon Session -->
    <div class="p-4 bg-gray-50 rounded-lg shadow border">
        <h3 class="text-lg font-semibold mb-4">Afternoon Session</h3>

        @if($afternoonAppointments->count())
        <div class="overflow-x-auto border border-gray-300 rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200 border-b border-gray-300 sticky top-0">
                    <tr>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Patient</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Date</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Time</th>
                        <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Status</th>
                        <th class="px-4 py-2 text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @foreach($afternoonAppointments as $appt)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $appt->patient->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($appt->status === 'pending') bg-yellow-100 text-yellow-800 @endif
                                @if($appt->status === 'completed') bg-green-100 text-green-800 @endif
                                @if($appt->status === 'canceled') bg-red-100 text-red-800 @endif">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if($appt->patient)
                            <button onclick="openPatientModal({{ $appt->patient->id }})"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                View History
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-sm">No afternoon appointments.</p>
        @endif
    </div>

</div>





    <!-- Patients Tab -->
    <div id="patients" class="tab-content hidden">
        <h3 class="text-lg font-semibold mb-2">Patients</h3>
        <div class="space-y-2">
            @php
                $patients = $appointments->map->patient->unique('id');
            @endphp

            @foreach($patients as $patient)
            <div class="p-4 bg-white rounded shadow border flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $patient->name }}</p>
                    <p class="text-gray-600">{{ $patient->email }}</p>
                </div>
                <button onclick="openPatientModal({{ $patient->id }})"
                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">View History</button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content hidden">
        @include('profile.partials.update-profile-information-form', ['user' => $dentist])
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</div>

<!-- Patient Modal -->
<div id="patient-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="relative w-11/12 md:w-1/2 bg-white rounded shadow-lg max-h-[80vh] flex flex-col">
        <!-- Close button at top-right corner -->
        <button onclick="closePatientModal()"
            class="absolute -top-4 -right-4 w-10 h-10 flex items-center justify-center text-2xl font-bold rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-900 shadow-lg">&times;</button>

        <!-- Scrollable content -->
        <div class="p-4 overflow-y-auto">
            <div id="patient-modal-content">
                <p class="text-gray-500 text-sm text-center">Select a patient to view history.</p>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
function openTab(tabId) {
    ['dashboard', 'patients', 'profile'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
        const btn = document.getElementById('sidebar-' + id);
        btn.classList.remove('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
    });

    document.getElementById(tabId).classList.remove('hidden');
    const activeBtn = document.getElementById('sidebar-' + tabId);
    activeBtn.classList.add('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
}

// Default tab
openTab('dashboard');

function openPatientModal(patientId) {
    const modal = document.getElementById('patient-modal');
    const content = document.getElementById('patient-modal-content');

    content.innerHTML = '<p class="text-gray-500 text-sm text-center">Loading...</p>';

    fetch(`/dentist/patients/${patientId}/history`)
        .then(res => res.text())
        .then(html => content.innerHTML = html)
        .catch(err => {
            content.innerHTML = '<p class="text-red-500 text-sm text-center">Failed to load history.</p>';
            console.error(err);
        });

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function closePatientModal() {
    const modal = document.getElementById('patient-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush
