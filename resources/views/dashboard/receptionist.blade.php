@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('sidebar')
    @include('dashboard.partials.receptionist_sidebar')
@endsection

@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ $user->name }}</h2>

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



<!--Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-4 mb-16">
    <div class="p-4 bg-blue-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Approved</p>
        <p class="font-bold text-xl">{{ $stats['approved'] }}</p>
    </div>
    <div class="p-4 bg-green-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Completed</p>
        <p class="font-bold text-xl">{{ $stats['completed'] }}</p>
    </div>
    <div class="p-4 bg-yellow-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Total Appointments</p>
        <p class="font-bold text-xl">{{ $stats['total'] }}</p>
    </div>
    <div class="p-4 bg-red-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
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
            <div class="p-4 bg-white rounded shadow border">
                <h3 class="text-lg font-semibold mb-2">Pending Appointments</h3>
                @if($pending->count())
                <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
                    <table class="min-w-full border-collapse text-left">
                        <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                            <tr>
                                <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                                <th class="px-4 py-2 border-r border-gray-300">Date</th>
                                <th class="px-4 py-2 border-r border-gray-300">Time</th>
                                <th class="px-4 py-2 border-r border-gray-300">Services</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-50">
                            @foreach($pending as $appointment)
                            <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    @php
                                        $serviceNames = ($appointment->services && $appointment->services->count())
                                            ? $appointment->services->pluck('name')->join(', ')
                                            : ($appointment->service->name ?? '-');
                                    @endphp
                                    {{ $serviceNames }}
                                </td>
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
            <div class="p-4 bg-white rounded shadow border">
                <h3 class="text-lg font-semibold mb-2">Approved Appointments</h3>
                @if($approved->count())
                <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
                    <table class="min-w-full border-collapse text-left">
                        <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                            <tr>
                                <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                                <th class="px-4 py-2 border-r border-gray-300">Date</th>
                                <th class="px-4 py-2 border-r border-gray-300">Time</th>
                                <th class="px-4 py-2 border-r border-gray-300">Services</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-50">
                            @foreach($approved as $appointment)
                            <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    @php
                                        $serviceNames = ($appointment->services && $appointment->services->count())
                                            ? $appointment->services->pluck('name')->join(', ')
                                            : ($appointment->service->name ?? '-');
                                    @endphp
                                    {{ $serviceNames }}
                                </td>
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
            <div class="p-4 bg-white rounded shadow border md:col-span-2">
                <h3 class="text-lg font-semibold mb-2">Cancellation Requests</h3>
                @if($cancellations->count())
                <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
                    <table class="min-w-full border-collapse text-left">
                        <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                            <tr>
                                <th class="px-4 py-2 border-r border-gray-300">Patient</th>
                                <th class="px-4 py-2 border-r border-gray-300">Date</th>
                                <th class="px-4 py-2 border-r border-gray-300">Time</th>
                                <th class="px-4 py-2 border-r border-gray-300">Services</th>
                                <th class="px-4 py-2 border-r border-gray-300">Notes</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-50">
                            @foreach($cancellations as $appointment)
                            <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                <td class="py-2 px-4 border-r border-gray-200">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    @php
                                        $serviceNames = ($appointment->services && $appointment->services->count())
                                            ? $appointment->services->pluck('name')->join(', ')
                                            : ($appointment->service->name ?? '-');
                                    @endphp
                                    {{ $serviceNames }}
                                </td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    @if($appointment->cancellation_reason)
                                    <button onclick="openNoteModal({{ $appointment->id }})"
                                            class="px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
                                        View Note
                                    </button>

                                    <!-- Note Modal -->
                                    <div id="note-modal-{{ $appointment->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                                        <div class="relative w-11/12 md:w-1/2 bg-white rounded shadow-lg p-4">
                                            <button onclick="closeNoteModal({{ $appointment->id }})"
                                                    class="absolute -top-4 -right-4 w-10 h-10 flex items-center justify-center text-2xl font-bold rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-900 shadow-lg">
                                                &times;
                                            </button>
                                            <h3 class="text-lg font-semibold mb-3">Note from {{ $appointment->patient->name ?? 'Patient' }}</h3>
                                            <p class="text-gray-700">{{ $appointment->cancellation_reason }}</p>
                                        </div>
                                    </div>
                                    @else
                                    -
                                    @endif
                                </td>
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

    <!-- All Appointments Tab -->
    <div class="tab-content hidden p-4 bg-white rounded shadow border" id="appointments">
        <h3 class="text-lg font-semibold mb-2">All Appointments</h3>
        @include('dashboard.partials.receptionist_appointments', ['list' => $allAppointments])
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content hidden p-4 bg-white rounded shadow border">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>

</div>

@push('scripts')
<script>

function openNoteModal(id) {
    const modal = document.getElementById(`note-modal-${id}`);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeNoteModal(id) {
    const modal = document.getElementById(`note-modal-${id}`);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openTab(tabId) {
    const tabs = ['dashboard', 'appointments', 'patients', 'reports', 'profile'];
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
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    const content = document.getElementById(tabId);
    if(content) content.classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || 'dashboard';
    openTab(tab);
});
</script>
@endpush

@endsection
