<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clinic Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #d5d5d5; }
        tbody tr:nth-child(even) { background-color: #e0e0e0; }
        h1 { text-align: center; }
        .stats { margin-top: 20px; }
        .stats div { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h1>Clinic Report</h1>

    <div class="stats">
        <div>Patients: {{ $stats['patients'] }}</div>
        <div>Dentists: {{ $stats['dentists'] }}</div>
        <div>Receptionists: {{ $stats['receptionists'] }}</div>
        <div>Appointments: {{ $stats['appointments'] }}</div>
        <div>Total Users: {{ $stats['total_users'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Dentist</th>
                <th>Date</th>
                <th>Time</th>
                <th>Services</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appt)
            <tr>
                <td>{{ $appt->patient->name }}</td>
                <td>{{ $appt->dentist->name }}</td>
                <td>{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                <td>
                    @php
                        $serviceNames = ($appt->services && $appt->services->count())
                            ? $appt->services->pluck('name')->join(', ')
                            : ($appt->service->name ?? '-');
                    @endphp
                    {{ $serviceNames }}
                </td>
                <td>{{ ucfirst($appt->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
