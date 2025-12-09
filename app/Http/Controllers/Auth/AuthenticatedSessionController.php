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

            // **Check if the account is suspended**
            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->with('error', 'Your account is suspended. Please contact admin.');
            }

            // Redirect based on role with success message
            return match($user->role_id) {
                1 => redirect()->route('patient.dashboard')->with('success', 'Logged in successfully!'),
                2 => redirect()->route('dentist.dashboard')->with('success', 'Logged in successfully!'),
                3 => redirect()->route('receptionist.dashboard')->with('success', 'Logged in successfully!'),
                4 => redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!'),
                default => redirect('/dashboard')->with('success', 'Logged in successfully!')
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials: Incorrect email or password.',
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
