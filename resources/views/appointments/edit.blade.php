@extends('layouts.app')

@section('content')

<div class="p-6 bg-gray-900 text-yellow-300 min-h-screen">

```
<h1 class="text-2xl font-bold mb-6">Edit Appointment</h1>

<form action="{{ route('appointments.update', $appointment) }}" method="POST" class="max-w-lg bg-gray-800 p-6 rounded-md">
    @csrf
    @method('PUT')

    {{-- Patient --}}
    <div class="mb-4">
        <label for="patient_id" class="block mb-1 font-semibold">Select Patient</label>
        <select name="patient_id" id="patient_id" class="w-full p-2 rounded bg-gray-700 text-yellow-300">
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
            @endforeach
        </select>
        @error('patient_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- Dentist --}}
    <div class="mb-4">
        <label for="dentist_id" class="block mb-1 font-semibold">Select Dentist</label>
        <select name="dentist_id" id="dentist_id" class="w-full p-2 rounded bg-gray-700 text-yellow-300">
            @foreach($dentists as $dentist)
                <option value="{{ $dentist->id }}" {{ $appointment->dentist_id == $dentist->id ? 'selected' : '' }}>{{ $dentist->name }}</option>
            @endforeach
        </select>
        @error('dentist_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- Service --}}
    <div class="mb-4">
        <label for="service_id" class="block mb-1 font-semibold">Select Service</label>
        <select name="service_id" id="service_id" class="w-full p-2 rounded bg-gray-700 text-yellow-300">
            @foreach($services as $service)
                <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
            @endforeach
        </select>
        @error('service_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- Date --}}
    <div class="mb-4">
        <label for="date" class="block mb-1 font-semibold">Select Date</label>
        <input type="date" name="date" id="date" class="w-full p-2 rounded bg-gray-700 text-yellow-300" value="{{ $appointment->date }}">
        @error('date')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- Time --}}
    <div class="mb-4">
        <label for="time" class="block mb-1 font-semibold">Select Time</label>
        <input type="time" name="time" id="time" class="w-full p-2 rounded bg-gray-700 text-yellow-300" value="{{ $appointment->time }}">
        @error('time')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- Status --}}
    <div class="mb-4">
        <label for="status" class="block mb-1 font-semibold">Status</label>
        <select name="status" id="status" class="w-full p-2 rounded bg-gray-700 text-yellow-300">
            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Update Appointment</button>
</form>
```

</div>
@endsection
