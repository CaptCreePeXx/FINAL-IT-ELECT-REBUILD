@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('sidebar')
@include('dashboard.partials.patient_sidebar')
@endsection

@section('content')

<!-- HEADER -->
<h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ $user->name }}</h2>

<!-- Book Appointment Button -->
<a href="{{ route('appointments.create') }}" 
   class="inline-flex items-center justify-center gap-3 mb-6 px-4 py-2 bg-[#C7E7EC] border-2 border-[#2F3E3C] text-[#2F3E3C] rounded-full font-semibold shadow hover:bg-[#AED9D1] hover:scale-105 transition-transform">

    <!-- Plus Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>

    Book Appointment
</a>



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




<!-- STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
    <div class="p-4 bg-yellow-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="font-bold text-xl">{{ $stats['pending'] }}</p>
    </div>

    <div class="p-4 bg-blue-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Approved</p>
        <p class="font-bold text-xl">{{ $stats['approved'] }}</p>
    </div>

    <div class="p-4 bg-green-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Completed</p>
        <p class="font-bold text-xl">{{ $stats['completed'] }}</p>
    </div>

    <div class="p-4 bg-red-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
        <p class="text-gray-600 text-sm">Declined</p>
        <p class="font-bold text-xl">{{ $stats['declined'] }}</p>
    </div>
</div>



<!-- UPCOMING APPOINTMENT -->
<div class="bg-blue-50 border border-blue-200 p-4 rounded-lg shadow mb-6">
    @if($next)
        <h3 class="font-semibold text-blue-700">Next Approved Appointment</h3>
        <p class="text-gray-700 mt-1">{{ \Carbon\Carbon::parse($next->date)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($next->time)->format('h:i A') }}</p>
        <p class="text-gray-700 mt-1">Service: {{ $next->service->name ?? 'Unknown Service' }}</p>
        <p class="text-gray-700 mt-1">Dentist: {{ $next->dentist->name ?? 'Unknown Dentist' }}</p>
    @else
        <p class="text-gray-600">No approved appointments yet.</p>
    @endif
</div>

<!-- TABS -->
<div class="border-b border-gray-300 mb-4">
    <ul class="flex gap-4" id="tabs">
        <li class="tab active text-blue-600 font-semibold pb-2 border-b-2 border-blue-600 cursor-pointer" data-tab="pending">Pending</li>
        <li class="tab text-gray-600 pb-2 cursor-pointer" data-tab="approved">Approved</li>
        <li class="tab text-gray-600 pb-2 cursor-pointer" data-tab="cancellations">Cancellation Requests</li>
        <li class="tab text-gray-600 pb-2 cursor-pointer" data-tab="history">History</li>
    </ul>
</div>

<!-- TAB CONTENTS -->
<div id="tab-contents">
    <div class="tab-content" id="pending">
        @include('dashboard.partials.patient_appointments', ['list' => $pending])
    </div>

    <div class="tab-content hidden" id="approved">
        @include('dashboard.partials.patient_appointments', ['list' => $approved])
    </div>

    <div class="tab-content hidden" id="cancellations">
        @include('dashboard.partials.patient_cancellations', ['list' => $cancellations])
    </div>

    <div class="tab-content hidden" id="history">
        @include('dashboard.partials.patient_appointments', ['list' => $history])
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
</script>
@endpush

@endsection
