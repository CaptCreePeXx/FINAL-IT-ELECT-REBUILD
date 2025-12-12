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

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Only show editable fields for patients --}}
            @if(auth()->user()->role_id == 1)
                {{-- Service --}}
                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Service</label>
                    <select name="service_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        <option value="">Select a service</option>
                        @foreach(App\Models\Service::all() as $service)
                            <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dentist --}}
                <div class="space-y-2">
                    <label for="dentist_id" class="block font-medium text-[#2F3E3C]">Dentist</label>
                    <select name="dentist_id" id="dentist_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        @foreach(App\Models\User::where('role_id', 2)->get() as $dentist)
                            <option value="{{ $dentist->id }}" {{ $appointment->dentist_id == $dentist->id ? 'selected' : '' }}>
                                {{ $dentist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Date</label>
                    <input type="date" name="date" required value="{{ $appointment->date }}"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                </div>

                {{-- Time --}}
                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Time</label>
                    <select name="time" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        <option value="">Select Session</option>
                        <option value="09:00:00" {{ $appointment->time == '09:00:00' ? 'selected' : '' }}>Morning Session (9:00 AM - 12:00 PM)</option>
                        <option value="13:00:00" {{ $appointment->time == '13:00:00' ? 'selected' : '' }}>Afternoon Session (1:00 PM - 4:00 PM)</option>
                    </select>
                </div>
            @else
                {{-- Admin / Receptionist can edit all fields --}}
                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Patient</label>
                    <select name="patient_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        @foreach(App\Models\User::where('role_id', 1)->get() as $patient)
                            <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Dentist</label>
                    <select name="dentist_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        @foreach(App\Models\User::where('role_id', 2)->get() as $dentist)
                            <option value="{{ $dentist->id }}" {{ $appointment->dentist_id == $dentist->id ? 'selected' : '' }}>
                                {{ $dentist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Service</label>
                    <select name="service_id" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        @foreach(App\Models\Service::all() as $service)
                            <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Date</label>
                    <input type="date" name="date" required value="{{ $appointment->date }}"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Time</label>
                    <select name="time" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        <option value="09:00:00" {{ $appointment->time == '09:00:00' ? 'selected' : '' }}>Morning Session (9:00 AM - 12:00 PM)</option>
                        <option value="13:00:00" {{ $appointment->time == '13:00:00' ? 'selected' : '' }}>Afternoon Session (1:00 PM - 4:00 PM)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-[#2F3E3C]">Status</label>
                    <select name="status" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            @endif

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
