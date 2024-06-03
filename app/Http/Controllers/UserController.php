<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register Form
    public function create()
    {
        return view('auth.register');
    }

    // Store new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/', Rule::unique('clients', 'phone_number')],
            'cin' => ['required', 'regex:/^[A-Za-z]\d{6}$/', Rule::unique('clients', 'cin')],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        // Create a new user
        $user = User::create([
            'username' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'client'
        ]);

        unset($data['email']);
        unset($data['password']);
        unset($data['password_confirmation']);

        // Create a new client
        $client = new Client($data);
        $client->user()->associate($user);
        $client->save();

        auth()->login($user);

        return redirect('/')->with('success', 'Welcome ' . $data['first_name'] . ' ' . $data['last_name'] . '!');
    }

    // Show Login Form
    public function login() {
        return view('auth.login');
    }

    // Authenticate Login Form
    public function authenticate(Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => 'required'
        ]);

        if (auth()->attempt($data, $request->remember)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'Welcome ' . auth()->user()->username . '!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    // Logout User
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
