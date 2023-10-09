<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        return inertia('Auth/Login',);
    }
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'user_id' => ['required'],
            'password' => 'required'
        ]);
        $user = null;
        if (filter_var($credentials['user_id'], FILTER_VALIDATE_EMAIL)) {
            $user = User::query()->where('email', $credentials['user_id'])->first();
        } else {
            $user = User::query()->where('mobile', $credentials['user_id'])->first();
        }
        if (blank($user)) {
            return back()->withErrors([
                'user_id' => 'User not found in our system'
            ]);
        }
        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors([
            'user_id' => 'Invalid credential',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
