@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('sidebar')
    @include('dashboard.partials.patient_sidebar')
@endsection

@section('content')
<div class="flex justify-center items-center min-h-screen bg-[#E8F0F1]">

    <!-- Edit Appointment Form Card -->
    <div class="w-full max-w-2xl bg-[#FBF9F1] p-6 rounded-2xl shadow-lg space-y-6">

        <h2 class="text-3xl font-bold text-[#2F3E3C] mb-6 text-left">Edit Appointment</h2>

        <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Service --}}
            <div class="space-y-2">
                <label class="block font-medium text-[#2F3E3C]">Service</label>
                <select name="service_id" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
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
                <label for="dentist_id" class="block font-medium text-[#2F3E3C]">Select Dentist</label>
                <select name="dentist_id" id="dentist_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                    @foreach($dentists as $dentist)
                        <option value="{{ $dentist->id }}" {{ $appointment->dentist_id == $dentist->id ? 'selected' : '' }}>
                            {{ $dentist->name }}
                        </option>
                    @endforeach
                </select>
                @error('dentist_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Time --}}
            <div class="space-y-2">
                <label class="block font-medium text-[#2F3E3C]">Time</label>
                <select name="time" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                    <option value="">Select Session</option>
                    <option value="09:00:00">Morning Session (9:00 AM - 12:00 PM)</option>
                    <option value="13:00:00">Afternoon Session (1:00 PM - 4:00 PM)</option>
                </select>
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-[#2F3E3C] to-[#3F4E4C] text-[#FBF9F1] font-semibold rounded-2xl shadow-lg hover:scale-105 transition-transform">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
