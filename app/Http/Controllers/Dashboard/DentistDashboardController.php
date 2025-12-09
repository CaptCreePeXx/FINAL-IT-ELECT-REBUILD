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

        // Fetch all appointments for this dentist
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

        // Fetch patients with active appointments for this dentist
        $patients = User::whereHas('patientAppointments', function($query) use ($dentist) {
            $query->where('dentist_id', $dentist->id)
                  ->where('status', 'approved'); // Only active appointments
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

    /**
     * Optional: For AJAX requests if needed in future
     * Fetch completed appointments for a patient
     */
    public function patientHistory($id)
    {
        $appointments = Appointment::with('dentist', 'service')
            ->where('patient_id', $id)
            ->where('status', 'completed')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $patient = User::findOrFail($id);

        return view('dashboard.partials.dentist-patient-history', compact('appointments', 'patient'));
    }

}



