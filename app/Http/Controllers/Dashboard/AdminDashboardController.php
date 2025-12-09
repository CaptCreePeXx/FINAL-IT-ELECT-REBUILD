<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        // Ensure only authenticated users can access
        $this->middleware('auth');

        // Restrict access to admins only
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id !== 4) { // 4 = Admin
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    // Admin dashboard view
    public function dashboard()
    {
        // Fetch all users, ordered by role
        $users = User::orderBy('role_id')->get();

        // Dashboard stats
        $stats = [
            'patients'      => User::where('role_id', 1)->count(),
            'dentists'      => User::where('role_id', 2)->count(),
            'receptionists' => User::where('role_id', 3)->count(),
            'appointments'  => Appointment::count(),
            'total_users'   => User::count(),
        ];

        return view('dashboard.admin', compact('users', 'stats'));
    }

    // Assign role to a user
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|integer|in:1,2,3,4',
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', "Role updated for {$user->name}");
    }

    // Toggle active/suspended status
    public function toggleStatus(User $user)
    {
        // Prevent admin from suspending themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', "You cannot suspend yourself.");
        }

        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        $status = $user->status;
        return redirect()->back()->with('success', "{$user->name} has been {$status}.");
    }
        
}


