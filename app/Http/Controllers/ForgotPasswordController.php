<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordWithTokenRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

     // Étape 1 : Afficher le formulaire (pas de token ici)
     public function showLinkRequestForm()
     {
         return view('dash.users.emailReset');
     }
 
     // Étape 2 : Envoyer le lien
     public function sendResetLinkEmail(ForgotPasswordRequest $request)
     {
         $status = $this->userService->sendResetLink($request->validated());
 
         return $status === Password::RESET_LINK_SENT
             ? back()->with('status', __('Un lien de réinitialisation a été envoyé.'))
             : back()->withErrors(['email' => __('Impossible d\'envoyer le lien de réinitialisation.')]);
     }
 
     //  Étape 3 : Afficher le formulaire de reset (avec token cette fois)
     public function showResetForm(Request $request, $token)
     {
         return view('dash.users.resetPassword', [
             'token' => $token,
             'email' => $request->email,
         ]);
     }
 
     public function reset(ResetPasswordWithTokenRequest $request)
     {
         $status = $this->userService->resetPassword($request->validated());
 
         return $status === Password::PASSWORD_RESET
             ? redirect()->route('login')->with('success', __('Mot de passe réinitialisé avec succès.'))
             : back()->withErrors(['email' => __($status)]);
     }

  
}
