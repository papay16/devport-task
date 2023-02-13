<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('register');
    }

    public function processRegister(RegisterRequest $request): RedirectResponse
    {
        if (!$user = User::firstOrCreate($request->validated())) {
            return redirect()->back()->withErrors(['username' => 'asdas']);
        }

        $user->links()->create([
            'hash' => Str::uuid(),
            'expires_at' => now()->addDays(7),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function cabinet(): View
    {
        $user = Auth::user();

        return view('cabinet', [
            'user' => $user,
            'links' => $user->links,
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        Session::regenerate();

        return redirect()->route('home');
    }
}
