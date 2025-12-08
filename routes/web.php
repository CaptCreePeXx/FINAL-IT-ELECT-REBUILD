<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Dashboard Controllers
use App\Http\Controllers\Dashboard\PatientDashboardController;
use App\Http\Controllers\Dashboard\DentistDashboardController;
use App\Http\Controllers\Dashboard\ReceptionistDashboardController;
use App\Http\Controllers\Dashboard\AdminDashboardController;

// Appointment Controller
use App\Http\Controllers\AppointmentController;

// -------------------------------------------------------
// LANDING PAGE
// -------------------------------------------------------
Route::get('/', fn() => view('custom-welcome'));

// -------------------------------------------------------
// LOGOUT
// -------------------------------------------------------
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

// -------------------------------------------------------
// ROLE-BASED DASHBOARD REDIRECT
// -------------------------------------------------------
Route::get('/dashboard', function () {
    $user = Auth::user();

    return match ($user->role_id) {
        1 => redirect()->route('patient.dashboard'),
        2 => redirect()->route('dentist.dashboard'),
        3 => redirect()->route('receptionist.dashboard'),
        4 => redirect()->route('admin.dashboard'),
        default => redirect('/login'),
    };
})->middleware(['auth'])->name('dashboard');

// -------------------------------------------------------
// PROFILE ROUTES
// -------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------------------------------------
// DASHBOARD ROUTES
// -------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'dashboard'])
        ->name('patient.dashboard');

    Route::get('/dentist/dashboard', [DentistDashboardController::class, 'dashboard'])
        ->name('dentist.dashboard');

    Route::get('/receptionist/dashboard', [ReceptionistDashboardController::class, 'dashboard'])
        ->name('receptionist.dashboard');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
        ->name('admin.dashboard');
});

// -------------------------------------------------------
// APPOINTMENT CRUD (ALL ROLES)
// -------------------------------------------------------
Route::middleware('auth')->resource('appointments', AppointmentController::class);

// -------------------------------------------------------
// PATIENT-SPECIFIC APPOINTMENT ACTIONS
// -------------------------------------------------------
Route::middleware('auth')->prefix('appointments')->group(function () {
    Route::post('{appointment}/cancel-pending',
        [PatientDashboardController::class, 'cancelPending'])
        ->name('appointments.cancelPending');

    Route::post('{appointment}/request-cancellation',
        [PatientDashboardController::class, 'requestCancellation'])
        ->name('appointments.requestCancellation');
});

// -------------------------------------------------------
// RECEPTIONIST-SPECIFIC ROUTES
// -------------------------------------------------------
Route::middleware('auth')->prefix('receptionist')->group(function () {
    Route::get('appointments',
        [ReceptionistDashboardController::class, 'dashboard'])
        ->name('receptionist.appointments');

    Route::post('appointments/{appointment}/approve',
        [ReceptionistDashboardController::class, 'approveAppointment'])
        ->name('receptionist.appointments.approve');

    Route::post('appointments/{appointment}/decline',
        [ReceptionistDashboardController::class, 'declineAppointment'])
        ->name('receptionist.appointments.decline');

    Route::post('appointments/{appointment}/complete',
        [ReceptionistDashboardController::class, 'completeAppointment'])
        ->name('receptionist.appointments.complete');

    Route::post('appointments/{appointment}/cancellation/approve',
        [ReceptionistDashboardController::class, 'approveCancellation'])
        ->name('receptionist.appointments.cancel.approve');

    Route::post('appointments/{appointment}/cancellation/reject',
        [ReceptionistDashboardController::class, 'rejectCancellation'])
        ->name('receptionist.appointments.cancel.reject');

    Route::get('reports',
        [ReceptionistDashboardController::class, 'reports'])
        ->name('receptionist.reports');
});

// -------------------------------------------------------
// DENTIST-SPECIFIC PATIENT HISTORY
// -------------------------------------------------------
Route::middleware('auth')->get('/dentist/patients/{id}/history', [DentistDashboardController::class, 'patientHistory'])
    ->name('dentist.patients.history');

// -------------------------------------------------------
// ADMIN ACTIONS
// -------------------------------------------------------
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::put('users/{user}',
        [AdminDashboardController::class, 'updateUser'])
        ->name('admin.updateUser');

    Route::post('users/{user}/assign-role',
        [AdminDashboardController::class, 'assignRole'])
        ->name('admin.assignRole');

    Route::post('users/{user}/toggle-status',
        [AdminDashboardController::class, 'toggleStatus'])
        ->name('admin.toggleStatus');
});

// -------------------------------------------------------
// AUTH ROUTES
// -------------------------------------------------------
require __DIR__ . '/auth.php';
