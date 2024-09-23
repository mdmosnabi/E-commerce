<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('admin.login'); // Create this view for the login form
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'passkey'  => 'required',
        ]);

        // Retrieve the admin user by username and passkey
        $admin = AdminModel::where('username', $request->username)
                            ->where('passkey', $request->passkey)
                            ->first();

        // Check if admin exists and password matches
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Store admin info in session (you can use other methods like tokens)
            session(['admin_logged_in' => true, 'admin_id' => $admin->id]);

            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
        }

        // If login fails, return back with error
        return back()->withErrors(['login' => 'Invalid credentials provided']);
    }

    // Logout the admin
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id']);
        return redirect()->route('admin.login'); // Redirect to the login page
    }
}
