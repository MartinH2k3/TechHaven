<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Handle login
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if the user is an admin
            if (Auth::user()->type === 'admin') {
                return redirect()->intended('admin-page');
            }

            return back();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show registration form
    public function registerView(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('customer.register');
    }

    // Handle registration
    public function register(Request $request): RedirectResponse
    {
        // Validate the request...
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);

        Auth::login($user);

        return redirect()->intended();
    }

    // Handle logout
    public function logout(Request $request): RedirectResponse
    {
        $isAdmin = Auth::user()->type === 'admin';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect('/'); // Assuming '/' is your homepage route
        }

        return back();
    }
}

