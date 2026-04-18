<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
       'name' => 'required|string|max:255',
       'email' => 'required|email|max:255|unique:users',
       'password' => 'required|min:6',
       'phone' => 'required|string|max:20',
       'gender' => 'required|in:male,female',
       'age' => 'required|integer|min:1|max:120',
       
        ]);

        if ($request->gender === 'male') {
    return redirect()->route('home')
        ->with('gender_error', 'الخدمة غير متوفرة للذكور حالياً، نسأل الله أن تتوفر قريباً.');
}

        $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'phone' => $request->phone,
             'gender' => $request->gender,
             'age' => $request->age,
             'role_id' => 3, // Default role_id for regular users

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
