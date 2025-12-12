<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        // All routes require authentication
        $this->middleware('auth');
    }

    /**
     * Display a list of appointments based on user role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) { // Patient
            $appointments = $user->patientAppointments()->with(['dentist', 'service'])->get();
        } elseif ($user->role_id == 2) { // Dentist
            $appointments = $user->dentistAppointments()->with(['patient', 'service'])->get();
        } else { // Receptionist / Admin
            $appointments = Appointment::with(['patient', 'dentist', 'service'])->get();
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create()
    {
        $patients = User::where('role_id', 1)->get();
        $dentists = User::where('role_id', 2)->get();
        $services = Service::all();

        return view('appointments.create', compact('patients', 'dentists', 'services'));
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        $request->validate([
            'dentist_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $data = $request->all();

        // If patient, auto-assign logged-in user's ID
        if (Auth::user()->role_id == 1) {
            $data['patient_id'] = Auth::id();
        } else {
            // Admin/receptionist must provide patient_id
            $request->validate([
                'patient_id' => 'required|exists:users,id',
            ]);
        }

        // Default status
        $data['status'] = 'pending';

        Appointment::create($data);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment created successfully.');
    }

    /**
     * Display a specific appointment
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing an appointment
     */
   public function edit(Appointment $appointment)
    {
        $user = Auth::user();

        // Restrict: patients can only edit their own pending appointments
        if ($user->role_id == 1) {
            if ($appointment->patient_id !== $user->id) {
                abort(403, 'Unauthorized');
            }

            if ($appointment->status !== 'pending') {
                return redirect()->back()->with('error', 'Only pending appointments can be edited.');
            }
        }

        $patients = User::where('role_id', 1)->get();
        $dentists = User::where('role_id', 2)->get();
        $services = Service::all();

        return view('appointments.edit', compact('appointment', 'patients', 'dentists', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
{
    $user = Auth::user();

    // Restrict patient edits
    if ($user->role_id == 1) {
        if ($appointment->patient_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be edited.');
        }

        // Patient can only edit dentist, service, date, and time
        $request->validate([
            'dentist_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment->update($request->only(['dentist_id', 'service_id', 'date', 'time']));

    } else {
        // Admin/receptionist full edit
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'dentist_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);

        $appointment->update($request->all());
    }

    return redirect()->route('patient.dashboard')->with('success', 'Appointment updated successfully.');
}

    /**
     * Delete an appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
