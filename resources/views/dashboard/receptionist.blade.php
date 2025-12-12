@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('sidebar')
    {{-- Pass the user separately for profile info --}}
    @include('dashboard.partials.receptionist_sidebar', ['user' => $user])
@endsection

@section('content')
<div class="min-h-screen bg-[#F5F7F8] p-6">

    <!-- Dashboard Container -->
    <div id="dashboard-container">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="relative bg-white rounded-3xl shadow-xl p-8 flex flex-col md:flex-row md:items-center md:justify-between overflow-hidden">
                <!-- Decorative Shapes -->
                <div class="absolute top-0 left-0 w-40 h-40 bg-[#5DAF9E]/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#F9A826]/10 rounded-full translate-x-1/2 translate-y-1/2"></div>

                <!-- Welcome Message -->
                <div class="z-10 flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-[#5DAF9E]/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#5DAF9E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-[#2F3E3C] mb-1">Welcome, {{ $user->name }}!</h1>
                            <p class="text-gray-600 text-lg">Here’s a snapshot of your appointments and patients.</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="mt-6 md:mt-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 z-10 w-full">
                    @php
                        $statCards = [
                            ['label' => 'Pending', 'value' => $stats['pending'], 'bg' => 'from-yellow-100 to-yellow-200'],
                            ['label' => 'Approved', 'value' => $stats['approved'], 'bg' => 'from-blue-100 to-blue-200'],
                            ['label' => 'Completed', 'value' => $stats['completed'], 'bg' => 'from-green-100 to-green-200'],
                            ['label' => 'Declined', 'value' => $stats['declined'], 'bg' => 'from-red-100 to-red-200'],
                        ];
                    @endphp
                    @foreach($statCards as $card)
                        <div class="flex-1 p-6 rounded-2xl shadow-lg bg-gradient-to-br {{ $card['bg'] }} flex flex-col items-center justify-center text-center transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <p class="text-gray-700 text-sm mb-1 font-medium">{{ $card['label'] }}</p>
                            <p class="font-bold text-2xl text-gray-900">{{ $card['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

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



        <!-- Ongoing Appointments Today -->
        @php
            use Carbon\Carbon;
            $today = Carbon::today();
            $allTodayAppointments = collect($approved)->filter(fn($a) => Carbon::parse($a->date)->isSameDay($today));
            $morningAppointments = $allTodayAppointments->filter(fn($a) => Carbon::parse($a->time)->hour < 12);
            $afternoonAppointments = $allTodayAppointments->filter(fn($a) => Carbon::parse($a->time)->hour >= 12);
        @endphp

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#2F3E3C] mb-4">Ongoing Appointments Today</h2>
            @if($allTodayAppointments->isEmpty())
                <p class="text-gray-500">No ongoing appointments today.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Morning -->
                    <div>
                        <h3 class="text-xl font-semibold text-[#5DAF9E] mb-2">Morning</h3>
                        @forelse($morningAppointments as $appointment)
                            <div class="bg-white rounded-xl shadow p-4 mb-3">
                                <p><strong>Patient:</strong> {{ $appointment->patient->name ?? 'Unknown' }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                                <p><strong>Dentist:</strong> {{ $appointment->dentist->name ?? 'Not Assigned' }}</p>
                                <p><strong>Service:</strong> {{ $appointment->service->name ?? '-' }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">No morning appointments.</p>
                        @endforelse
                    </div>
                    <!-- Afternoon -->
                    <div>
                        <h3 class="text-xl font-semibold text-[#F9A826] mb-2">Afternoon</h3>
                        @forelse($afternoonAppointments as $appointment)
                            <div class="bg-white rounded-xl shadow p-4 mb-3">
                                <p><strong>Patient:</strong> {{ $appointment->patient->name ?? 'Unknown' }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                                <p><strong>Dentist:</strong> {{ $appointment->dentist->name ?? 'Not Assigned' }}</p>
                                <p><strong>Service:</strong> {{ $appointment->service->name ?? '-' }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">No afternoon appointments.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        <!-- Tabs Navigation -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-wrap gap-2 md:gap-4">
                @foreach(['pending', 'approved', 'completed', 'declined', 'cancellations'] as $tab)
                    <button class="tab-btn px-4 py-2 font-semibold rounded-md border-b-2 @if($loop->first) border-[#5DAF9E] text-[#2F3E3C] active @else border-transparent text-gray-500 hover:text-[#2F3E3C] @endif" data-tab="{{ $tab }}">
                        {{ ucfirst($tab) }} ({{ count($$tab) }})
                    </button>
                @endforeach
            </div>
            <input type="text" id="appointmentSearch" placeholder="Search by patient, dentist, or service..." class="px-4 py-2 rounded-lg border w-full md:w-96 focus:outline-none focus:ring-2 focus:ring-[#5DAF9E] shadow-sm">
        </div>

        <!-- Tabs Content -->
        @foreach(['pending', 'approved', 'completed', 'declined', 'cancellations'] as $tab)
            <div id="{{ $tab }}-tab" class="tab-pane @if($loop->first) block @else hidden @endif">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="{{ $tab }}-container">
                    @foreach($$tab as $appointment)
                        <div class="relative bg-white rounded-3xl p-6 shadow hover:shadow-2xl transition transform duration-300 appointment-card">
                            <!-- Status badge -->
                            <div class="absolute -top-2 right-0 px-4 py-1 rounded-bl-2xl text-white font-semibold
                                @switch($appointment->status)
                                    @case('pending') bg-yellow-400 @break
                                    @case('approved') bg-blue-400 @break
                                    @case('completed') bg-green-400 @break
                                    @case('declined') bg-red-400 @break
                                    @default bg-gray-400
                                @endswitch">
                                {{ $appointment->status === 'cancellation_requested' ? 'Cancellation Request' : ucfirst($appointment->status) }}
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-lg font-bold text-[#2F3E3C]">{{ $appointment->patient->name ?? 'Unknown' }}</h4>
                                <div class="flex gap-2 items-center text-gray-500">
                                    <span class="text-sm">{{ $appointment->dentist->name ?? 'Not Assigned' }}</span>
                                </div>
                            </div>
                            <div class="mb-4 text-gray-700 space-y-1">
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                                <p><strong>Service:</strong> {{ $appointment->service->name ?? '-' }}</p>
                                @if($appointment->status === 'cancellation_requested')
                                    <p><strong>Reason:</strong> {{ $appointment->cancellation_reason ?? '-' }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 flex-wrap">
                                @if($appointment->status == 'pending')
                                    <form method="POST" action="{{ route('receptionist.appointments.approve', $appointment->id) }}"> @csrf
                                        <button class="flex-1 px-3 py-2 rounded-full bg-[#F9A826] text-white font-semibold hover:bg-[#e58d1f] transition">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('receptionist.appointments.decline', $appointment->id) }}"> @csrf
                                        <button class="flex-1 px-3 py-2 rounded-full bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition">Decline</button>
                                    </form>
                                @elseif($appointment->status == 'approved')
                                    <form method="POST" action="{{ route('receptionist.appointments.complete', $appointment->id) }}"> @csrf
                                        <button class="flex-1 px-3 py-2 rounded-full bg-[#5DAF9E] text-white font-semibold hover:bg-[#4aa289] transition">Complete</button>
                                    </form>
                                @elseif($appointment->status === 'cancellation_requested')
                                    <form method="POST" action="{{ route('receptionist.appointments.cancel.approve', $appointment->id) }}"> @csrf
                                        <button class="flex-1 px-3 py-2 rounded-full bg-red-500 text-white font-semibold hover:bg-red-600 transition">Approve Cancellation</button>
                                    </form>
                                    <form method="POST" action="{{ route('receptionist.appointments.cancel.reject', $appointment->id) }}"> @csrf
                                        <button class="flex-1 px-3 py-2 rounded-full bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition">Reject</button>
                                    </form>
                                @endif

                                @if($tab !== 'declined')
                                    <button onclick="toggleModal('modal-{{ $appointment->patient_id }}')" class="px-3 py-2 rounded-full bg-[#5DAF9E] text-white font-semibold hover:bg-[#4aa289] transition">More Details</button>
                                @endif
                            </div>
                        </div>

                        <!-- Modal per patient -->
                        <div id="modal-{{ $appointment->patient_id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[80vh] flex flex-col">
                                <button onclick="toggleModal('modal-{{ $appointment->patient_id }}')" class="absolute top-3 right-3 w-9 h-9 flex items-center justify-center text-2xl font-bold rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 shadow-lg z-50">&times;</button>
                                <div class="p-6 overflow-y-auto">
                                    <h3 class="text-xl font-bold mb-4">Appointment History: {{ $appointment->patient->name ?? 'Unknown' }}</h3>
                                    @forelse($appointment->patient->patientAppointments as $history)
                                        <div class="mb-4 p-4 border rounded-xl bg-gray-50 shadow-sm">
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($history->date)->format('M d, Y') }}</p>
                                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($history->time)->format('h:i A') }}</p>
                                            <p><strong>Dentist:</strong> {{ $history->dentist->name ?? 'Not Assigned' }}</p>
                                            <p><strong>Service:</strong> {{ $history->service->name ?? '-' }}</p>
                                            @if($history->status === 'cancellation_requested')
                                                <p><strong>Cancellation Reason:</strong> {{ $history->cancellation_reason ?? '-' }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-gray-500">No appointment history found.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Profile Tab -->
    <div id="profile-container" class="hidden">
        <div class="p-4 bg-white rounded shadow border">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Tab switching inside dashboard
    function openTab(tabId) {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
        document.getElementById(tabId + '-tab').classList.remove('hidden');
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active','border-[#5DAF9E]','text-[#2F3E3C]');
        });
        document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active','border-[#5DAF9E]','text-[#2F3E3C]');
    }

    document.querySelectorAll('.tab-btn').forEach(btn => btn.addEventListener('click', () => openTab(btn.dataset.tab)));
    openTab('pending');

    // Sidebar Profile handling
    function openSidebarTab(tab) {
        if(tab === 'profile') {
            document.getElementById('dashboard-container').classList.add('hidden');
            document.getElementById('profile-container').classList.remove('hidden');
        } else {
            document.getElementById('dashboard-container').classList.remove('hidden');
            document.getElementById('profile-container').classList.add('hidden');
        }
    }

    // Modal toggle
    function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }

    // Example: Sidebar buttons should call openSidebarTab('profile') or openSidebarTab('dashboard')
</script>
@endpush
@endsection
