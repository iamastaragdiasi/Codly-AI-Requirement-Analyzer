<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function create(): View
    {
        return view('login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => 'required|email|max:255', 'password' => 'required|string|max:255']);
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => 'The supplied credentials are invalid.']);
        }
        $request->session()->regenerate();

        return redirect()->intended(route('projects.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
