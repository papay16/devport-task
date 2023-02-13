<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('register');
    }

    public function processRegister(RegisterRequest $request, UserService $userService): RedirectResponse
    {
        if (!$user = $userService->createNewUser($request->getData())) {
            return redirect()->back()->withErrors(['username' => 'Check please your information and try again']);
        }

        Auth::login($user);
        return redirect()->route('home');
    }

    public function cabinet(UserService $userService): View
    {
        return view('cabinet', [
            'links' => $userService->getUserLinks(Auth::id()),
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        Session::regenerate();

        return redirect()->route('home');
    }

    public function pageA(string $hash, UserService $userService): View| RedirectResponse
    {
        $link = $userService->getUserLink(Auth::id(), $hash);
        if (!$link) {
            return redirect()->route('home');
        }

        return view('page-a', ['link' => $link]);
    }

    public function newLink(string $hash, UserService $userService): RedirectResponse
    {
        if (!$userService->userHasLink(Auth::id(), $hash)) {
            return redirect()->route('home');
        }

        $newLink = $userService->createNewLinkForUser(Auth::id());

        return redirect()->route('page-a', ['hash' => $newLink->hash]);
    }

    public function deactivateLink(string $hash, UserService $userService): RedirectResponse
    {
        if ($userService->userHasLink(Auth::id(), $hash)) {
            $userService->deactivateLink($hash);
        }

        return redirect()->route('home');
    }
}
