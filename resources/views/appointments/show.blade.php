@extends('layouts.app')

@section('content')

<div class="p-6 bg-gray-900 text-yellow-300 min-h-screen">

```
<h1 class="text-2xl font-bold mb-6">Appointment Details</h1>

<div class="max-w-lg bg-gray-800 p-6 rounded-md">
    <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
    <p><strong>Dentist:</strong> {{ $appointment->dentist->name }}</p>
    <p><strong>Service:</strong> {{ $appointment->service->name }} - ₱{{ number_format($appointment->service->price, 2) }}</p>
    <p><strong>Date:</strong> {{ $appointment->date }}</p>
    <p><strong>Time:</strong> {{ $appointment->time }}</p>
    <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
</div>

<div class="mt-6">
    <a href="{{ route('appointments.index') }}" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Back to Appointments</a>
</div>
```

</div>
@endsection
