<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;

class DentistDashboardController extends Controller
{
    public function __construct()
    {
        // Restrict access to dentists only
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 2) { // 2 = Dentist
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        // Get logged-in dentist
        $dentist = Auth::user();

        // Pass $user for profile forms
        $user = $dentist;

        // Fetch all appointments for this dentist (sorted by date & time)
        $appointments = Appointment::where('dentist_id', $dentist->id)
                            ->orderBy('date', 'asc')
                            ->orderBy('time', 'asc')
                            ->get();

        // Filter upcoming appointments: approved & future
        $upcomingAppointments = $appointments->filter(function($appt) {
            return $appt->status === 'approved' && $appt->date >= now()->toDateString();
        });

        // Calculate stats
        $stats = [
            'upcoming'  => $upcomingAppointments->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'total'     => $appointments->count(),
        ];

        // Fetch patients related to this dentist's appointments
        $patients = User::whereHas('patientAppointments', function($query) use ($dentist) {
            $query->where('dentist_id', $dentist->id);
        })->get();

        return view('dashboard.dentist', compact(
            'dentist',
            'user',
            'appointments',
            'upcomingAppointments',
            'stats',
            'patients'
        ));
    }

    public function upcomingAppointments()
    {
        $patientId = auth()->id(); // Get current patient ID

        $appointments = Appointment::where('patient_id', $patientId)
            ->where('status', 'approved') // Only confirmed appointments
            ->whereDate('appointment_date', '>=', now()->toDateString()) // Only future or today
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('dashboard.patient.upcoming', compact('appointments'));
    }

    public function patientHistory($id)
    {
        $appointments = Appointment::with('patient')
            ->where('patient_id', $id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $patient = User::findOrFail($id);

        return view('dashboard.partials.patient-history', compact('appointments', 'patient'));
    }
}
