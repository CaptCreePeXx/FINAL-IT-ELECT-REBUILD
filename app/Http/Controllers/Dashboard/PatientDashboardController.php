<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;

class PatientDashboardController extends Controller
{
    public function __construct()
    {
        // Middleware to restrict access to patients only
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 1) { // 1 = Patient
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Fetch all appointments
        $appointments = Appointment::where('patient_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        // Group by status
        $pending   = $appointments->where('status', 'pending');
        $approved  = $appointments->where('status', 'approved');
        $completed = $appointments->where('status', 'completed');
        $declined  = $appointments->where('status', 'declined');
        $cancelled = $appointments->where('status', 'cancelled');

        // Cancellation requests (still waiting)
        $cancellations = $appointments->where('status', 'cancellation_requested');

        // History = completed + declined + cancelled
        $history = $appointments->whereIn('status', ['completed','declined','cancelled']);

        // Stats
        $stats = [
            'pending'   => $pending->count(),
            'approved'  => $approved->count(),
            'completed' => $completed->count(),
            'declined'  => $declined->count(),
            'total'     => $appointments->count(),
        ];

        // Next approved appointment
        $next = $approved->sortBy('date')->first();

        return view('dashboard.patient', compact(
            'user',
            'stats',
            'pending',
            'approved',
            'completed',
            'declined',
            'history',
            'cancellations',
            'next'
        ));
    }

    // Patient cancels pending appointment (delete)
    public function cancelPending(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Cannot cancel this appointment directly.');
        }

        $appointment->delete();
        return back()->with('success', 'Appointment cancelled successfully.');
    }

    // Patient requests cancellation for approved appointment
    public function requestCancellation(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'approved') {
            return back()->with('error', 'Cannot request cancellation for this appointment.');
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $appointment->status = 'cancellation_requested';
        $appointment->cancellation_reason = $request->reason;
        $appointment->save();

        return back()->with('success', 'Cancellation request submitted.');
    }
}
