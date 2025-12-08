<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FBF9F1] text-[#2F3E3C] flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-[#2F3E3C] min-h-screen p-4 shadow-lg rounded-r-lg flex flex-col gap-2">
        <a href="{{ route('patient.dashboard') }}" 
           class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black font-semibold text-[#FBF9F1]">Dashboard</a>
        <a href="{{ route('appointments.index') }}" 
           class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black font-semibold text-[#FBF9F1]">Book Appointment</a>
        <a href="{{ route('profile.edit') }}" 
           class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black font-semibold text-[#FBF9F1]">Profile</a>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 p-6 space-y-6">
        {{-- Paste the entire content section here from your previous patient dashboard blade --}}
    </main>

</body>
</html>


@extends('layouts.app')

@section('sidebar')
<nav class="flex flex-col gap-2 p-4 bg-[#2F3E3C] h-full min-h-screen shadow-lg rounded-r-lg">
    <a href="{{ route('patient.dashboard') }}"
       class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black transition font-semibold text-[#FBF9F1]">
        Dashboard
    </a>
    <a href="{{ route('appointments.index') }}"
       class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black transition font-semibold text-[#FBF9F1]">
        Book Appointment
    </a>
    <a href="{{ route('profile.edit') }}"
       class="px-4 py-2 rounded hover:bg-[#C7E7EC] hover:text-black transition font-semibold text-[#FBF9F1]">
        Profile
    </a>
</nav>
@endsection

@section('content')
<div class="container mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-[#2F3E3C]">Patient Dashboard</h1>

    {{-- Dashboard Stats --}}
    <div class="grid grid-cols-3 gap-6">
        <div class="p-4 bg-[#E7E9E3] rounded-lg shadow-md border-l-4 border-[#C7E7EC] hover:shadow-lg transition text-center">
            <p class="text-[#2F3E3C] font-semibold">Upcoming</p>
            <p class="text-2xl font-bold">{{ $stats['upcoming'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-[#E7E9E3] rounded-lg shadow-md border-l-4 border-[#C7E7EC] hover:shadow-lg transition text-center">
            <p class="text-[#2F3E3C] font-semibold">Completed</p>
            <p class="text-2xl font-bold">{{ $stats['completed'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-[#E7E9E3] rounded-lg shadow-md border-l-4 border-[#C7E7EC] hover:shadow-lg transition text-center">
            <p class="text-[#2F3E3C] font-semibold">Total Appointments</p>
            <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Upcoming Appointments --}}
    <div class="bg-[#FBF9F1] shadow-md rounded-lg p-4 border border-[#E8F0F1]">
        <h2 class="text-2xl font-semibold text-[#2F3E3C] mb-4">Upcoming Appointments</h2>
        <table class="min-w-full border rounded-lg overflow-hidden">
            <thead class="bg-[#C7E7EC] text-[#2F3E3C] border-b border-[#2F3E3C]">
                <tr>
                    <th class="py-2 px-4 border">Dentist</th>
                    <th class="py-2 px-4 border">Date</th>
                    <th class="py-2 px-4 border">Time</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Action</th>
                </tr>
            </thead>
            <tbody class="bg-[#E8F0F1]">
                @foreach($upcomingAppointments ?? [] as $appointment)
                <tr class="hover:bg-[#BDDBD1] transition">
                    <td class="py-2 px-4 border">{{ $appointment->dentist->name }}</td>
                    <td class="py-2 px-4 border">{{ $appointment->date->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border">{{ $appointment->time }}</td>
                    <td class="py-2 px-4 border">{{ ucfirst($appointment->status) }}</td>
                    <td class="py-2 px-4 border flex gap-2">
                        <a href="{{ route('appointments.show', $appointment) }}" 
                           class="px-3 py-1 bg-[#C7E7EC] text-[#2F3E3C] rounded hover:bg-[#E8F0F1] transition">View</a>
                        @if($appointment->status === 'upcoming')
                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-1 bg-[#2F3E3C] text-[#FBF9F1] rounded hover:bg-[#BDDBD1] hover:text-black transition">
                                Cancel
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-[#E7E9E3] shadow-md rounded-lg p-4 hover:shadow-lg transition">
        <h2 class="text-xl font-semibold text-[#2F3E3C] mb-2">Quick Actions</h2>
        <a href="{{ route('appointments.index') }}" 
           class="inline-block px-4 py-2 bg-[#C7E7EC] text-[#2F3E3C] rounded hover:bg-[#E8F0F1] transition">Book New Appointment</a>
    </div>
</div>
@endsection
