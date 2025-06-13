<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\UserService;

class UserLoginController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        return view('dash.users.login'); // Ta vue Blade contenant ton HTML
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->userService->login($request->validated(), $request->boolean('remember'));

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        if ($user->force_password_reset) {
            return redirect()->route('password.reset.forced');
        }

        if ($this->userService->needsProfileCompletion($user)) {
            return redirect()->route('profile.complete');
        }

        return redirect()->intended('/home');
    }

    public function logout(): RedirectResponse
    {
        $this->userService->logout();
        return redirect()->route('login');
    }
}