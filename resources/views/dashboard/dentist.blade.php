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

    @if(session('success'))
<div id="flash-message" 
     class="fixed top-4 right-4 max-w-sm w-full p-4 bg-green-600 text-white rounded-lg shadow-lg border-l-4 border-green-800 flex items-start gap-3 opacity-0 translate-x-10 z-50">
    <!-- Icon -->
    <svg class="w-6 h-6 flex-shrink-0 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <!-- Message -->
    <div class="flex-1">
        <p class="font-medium">Success</p>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
    <!-- Close button -->
    <button onclick="document.getElementById('flash-message').remove()" 
            class="text-white hover:text-gray-200 font-bold">&times;</button>
</div>

<script>
    const flash = document.getElementById('flash-message');
    if(flash){
        // Animate in
        setTimeout(() => {
            flash.classList.add('transition', 'duration-500', 'ease-out');
            flash.classList.remove('opacity-0', 'translate-x-10');
            flash.classList.add('opacity-100', 'translate-x-0');
        }, 50);

        // Auto-remove after 4 seconds
        setTimeout(() => {
            flash.classList.add('opacity-0', 'translate-x-10');
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }
</script>
@endif


    <!-- Dashboard Stats -->
    <div id="dashboard" class="tab-content">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
            <div class="p-4 bg-blue-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
                <p class="text-gray-600 text-sm">Upcoming Appointments</p>
                <p class="font-bold text-xl">{{ $stats['upcoming'] }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
                <p class="text-gray-600 text-sm">Completed Appointments</p>
                <p class="font-bold text-xl">{{ $stats['completed'] }}</p>
            </div>
            <div class="p-4 bg-yellow-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
                <p class="text-gray-600 text-sm">Total Appointments</p>
                <p class="font-bold text-xl">{{ $stats['total'] }}</p>
            </div>
        </div>
    </div>

        <!-- Upcoming Appointments Table -->
        <div class="p-4 bg-gray-50 rounded-lg shadow border mb-6">
            <h3 class="text-lg font-semibold mb-4">Upcoming Appointments</h3>
            @if($upcomingAppointments->count())
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-200 border-b border-gray-300 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Patient</th>
                            <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Date</th>
                            <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Time</th>
                            <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 border-r border-gray-300 text-sm font-medium text-gray-600">Services</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50">
                        @foreach($upcomingAppointments as $appt)
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
                                @php
                                    $serviceNames = ($appt->services && $appt->services->count())
                                        ? $appt->services->pluck('name')->join(', ')
                                        : ($appt->service->name ?? '-');
                                @endphp
                                {{ $serviceNames }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-gray-500 text-sm">No upcoming appointments.</p>
            @endif
        </div>

        <!-- Patients Accordion -->
        <div class="p-4 bg-gray-50 rounded-lg shadow border">
            <h3 class="text-lg font-semibold mb-4">Patients</h3>
            <div class="space-y-2">
                @foreach($patients as $patient)
                <div class="bg-white rounded shadow border">
                    <!-- Patient Header -->
                    <div class="flex justify-between items-center p-4 cursor-pointer"
                        onclick="togglePatientHistory({{ $patient->id }})">
                        <div>
                            <p class="font-semibold">{{ $patient->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $patient->email }}</p>
                        </div>
                        <span id="chevron-{{ $patient->id }}" class="material-icons text-gray-600 transition-transform">
                            expand_more
                        </span>
                    </div>

                    <!-- Patient History (Hidden) -->
                    <div id="patient-history-{{ $patient->id }}" class="p-4 border-t border-gray-200 hidden bg-gray-50">
                        @php
                            $patientAppointments = $appointments->where('patient_id', $patient->id)->where('status', 'completed');
                        @endphp
                        @if($patientAppointments->count())
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Date</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Time</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Services</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600">Dentist</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patientAppointments as $appt)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $serviceNames = ($appt->services && $appt->services->count())
                                                ? $appt->services->pluck('name')->join(', ')
                                                : ($appt->service->name ?? '-');
                                        @endphp
                                        {{ $serviceNames }}
                                    </td>
                                    <td class="px-4 py-2">{{ $appt->dentist->name ?? $dentist->name ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-gray-500 text-sm">No completed appointments.</p>
                        @endif
                    </div>
                </div>
                @endforeach
                @if($patients->isEmpty())
                    <p class="text-gray-500 text-sm">No current patients assigned.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content hidden">
        @include('profile.partials.update-profile-information-form', ['user' => $dentist])
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection

@push('scripts')
<script>
function openTab(tabId) {
    ['dashboard', 'profile'].forEach(id => {
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

function togglePatientHistory(patientId) {
    const historyDiv = document.getElementById(`patient-history-${patientId}`);
    const chevron = document.getElementById(`chevron-${patientId}`);
    if(historyDiv && chevron) {
        historyDiv.classList.toggle('hidden');
        chevron.style.transform = historyDiv.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }
}
</script>
@endpush
