<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function showForm() {

        if (Auth::user()) {
            toastr("Welcome back!", Type::SUCCESS);
            return redirect()->intended(route("index"));
        }

        return view("login");
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->user_type == 3) {
            toastr("Welcome!", Type::SUCCESS);
            return redirect()->route("ballot.voter");
        }

        toastr("Welcome!", Type::SUCCESS);
        return redirect()->intended(route("index"));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route("loginPage"));
    }
}
