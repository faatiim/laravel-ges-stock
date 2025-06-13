<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForcePasswordController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function showForceResetForm()
    {
        return view('dash.users.forceResetPassword');
    }


    public function handleForceReset(ResetPasswordRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->userService->forceResetPassword($user, $request->password);

        return redirect()->route('dashboard')->with('success', 'Bienvenue, Vos informations ont bien été enregistrer avec succès.');
    }
}
