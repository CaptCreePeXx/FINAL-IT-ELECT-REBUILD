<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;

class ReceptionistDashboardController extends Controller
{
    public function __construct()
    {
        // Restrict access to receptionists only
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 3) { // 3 = Receptionist
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Fetch all appointments with patient, dentist, and service relationships, most recent first
        $appointments = Appointment::with(['patient', 'dentist', 'service'])
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get();

        // Split appointments by status
        $pending        = $appointments->where('status', 'pending');
        $approved       = $appointments->where('status', 'approved');
        $completed      = $appointments->where('status', 'completed');
        $declined       = $appointments->where('status', 'declined');
        $cancellations  = $appointments->where('status', 'cancellation_requested');

        // Patients list for the Patients tab
        $patients = $request->has('search')
            ? User::where('role_id', 1)
                ->where(function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                      ->orWhere('email', 'like', "%{$request->search}%");
                })
                ->get()
            : User::where('role_id', 1)->get();

        // Stats
        $stats = [
            'pending'   => $pending->count(),
            'approved'  => $approved->count(),
            'completed' => $completed->count(),
            'declined'  => $declined->count(),
            'total'     => $appointments->count(),
            'patients'  => $patients->count(),
        ];

        return view('dashboard.receptionist', compact(
            'user',
            'pending',
            'approved',
            'completed',
            'declined',
            'cancellations',
            'patients',
            'stats'
        ))->with('allAppointments', $appointments);
    }

    public function approveAppointment(Appointment $appointment)
    {
        $appointment->status = 'approved';
        $appointment->save();
        return back()->with('success', 'Appointment approved.');
    }

    public function declineAppointment(Appointment $appointment)
    {
        $appointment->status = 'declined';
        $appointment->save();
        return back()->with('success', 'Appointment declined.');
    }

    public function completeAppointment(Appointment $appointment)
    {
        $appointment->status = 'completed';
        $appointment->save();
        return back()->with('success', 'Appointment completed.');
    }

    public function approveCancellation(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->save();
        return back()->with('success', 'Cancellation request approved.');
    }

    public function rejectCancellation(Appointment $appointment)
    {
        $appointment->status = 'approved';
        $appointment->save();
        return back()->with('success', 'Cancellation request rejected.');
    }

    public function viewPatientAppointments(User $patient)
    {
        $appointments = $patient->appointments()
            ->with(['service', 'dentist'])
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get();

        return view('dashboard.receptionist_patient_appointments', compact('patient', 'appointments'));
    }
}
