<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate email, password, and role
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Check if the selected role matches the user's role
            if ($user->role_id != $request->role_id) {
                Auth::logout();
                return back()->with('error', 'Invalid credentials: Incorrect role selected.');
            }

            // Redirect based on role
            return match($user->role_id) {
                1 => redirect()->route('patient.dashboard'),
                2 => redirect()->route('dentist.dashboard'),
                3 => redirect()->route('receptionist.dashboard'),
                4 => redirect()->route('admin.dashboard'),
                default => redirect('/dashboard')
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
