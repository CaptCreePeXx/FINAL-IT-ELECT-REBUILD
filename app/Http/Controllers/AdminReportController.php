<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportController extends Controller
{
    /**
     * Display the admin report page (HTML view)
     */
    public function index()
    {
        // Collect statistics
        $stats = [
            'patients' => User::where('role_id', 1)->count(),
            'dentists' => User::where('role_id', 2)->count(),
            'receptionists' => User::where('role_id', 3)->count(),
            'appointments' => Appointment::count(),
            'total_users' => User::count(),
        ];

        // Retrieve all appointments with patient and dentist relationship
        $appointments = Appointment::with('patient', 'dentist', 'service')->get();

        // Return the Blade view for HTML display
        return view('admin.reports', compact('stats', 'appointments'));
    }

    /**
     * Export the admin report as a PDF
     */
    public function exportPdf()
    {
        // Collect statistics
        $stats = [
            'patients' => User::where('role_id', 1)->count(),
            'dentists' => User::where('role_id', 2)->count(),
            'receptionists' => User::where('role_id', 3)->count(),
            'appointments' => Appointment::count(),
            'total_users' => User::count(),
        ];

        // Retrieve all appointments with patient and dentist relationship
        $appointments = Appointment::with('patient', 'dentist', 'service')->get();

        // Load PDF view
        $pdf = Pdf::loadView('admin.reports-pdf', compact('stats', 'appointments'))
                  ->setPaper('a4', 'landscape'); // Set PDF size and orientation

        // Download the PDF
        return $pdf->download('clinic_report_' . now()->format('Y_m_d_H_i') . '.pdf');
    }
}
