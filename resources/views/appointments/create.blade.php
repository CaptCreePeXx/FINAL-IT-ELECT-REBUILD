@extends('layouts.app')

@section('title', 'Book Appointment')

@section('sidebar')
    @include('dashboard.partials.patient_sidebar')
@endsection

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl">

        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-left">Book Appointment</h2>

        <div class="bg-gray-100 p-8 rounded-xl shadow-lg space-y-6">

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="p-4 bg-red-600 text-white rounded-lg shadow">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div id="flash-message" class="p-4 bg-green-600 text-white rounded-lg shadow">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        const msg = document.getElementById('flash-message');
                        if(msg) {
                            msg.classList.add('transition', 'opacity-0');
                            setTimeout(() => msg.remove(), 500);
                        }
                    }, 4000);
                </script>
            @endif

            {{-- Form --}}
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Service --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Service</label>
                    <select name="service_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Select a service</option>
                        <option value="1">Tooth Extraction</option>
                        <option value="2">Teeth Cleaning</option>
                        <option value="3">Root Canal Treatment</option>
                        <option value="4">Dental Filling</option>
                        <option value="5">Braces Consultation</option>
                    </select>
                </div>

                {{-- Dentist --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Dentist</label>
                    <select name="dentist_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Select a dentist</option>
                        @foreach($dentists as $dentist)
                            <option value="{{ $dentist->id }}">{{ $dentist->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Date</label>
                    <input type="date" name="date" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                {{-- Time --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Time</label>
                    <select name="time" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Select Session</option>
                        <option value="09:00:00">Morning Session (9:00 AM - 12:00 PM)</option>
                        <option value="13:00:00">Afternoon Session (1:00 PM - 4:00 PM)</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold rounded-lg shadow hover:from-green-700 hover:to-green-600 transition-all">
                        Book Appointment
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
