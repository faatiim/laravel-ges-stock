<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showAdminRegistrationForm()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('dash.users.register', compact('roles'));
    }

    public function register(AdminRegisterUserRequest $request): RedirectResponse
    {
        $this->userService->createWithEmailRoleOnly($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur enregistré avec succès. Il devra compléter son profil.');
    }
}
