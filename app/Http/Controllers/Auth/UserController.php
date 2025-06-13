<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Outil;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function index(): View
    {
        $roles = Role::all();
        $users = User::with('roles')->latest()->get();
        return view('dash.users.index', compact('users'), compact('roles'));
    }

    public function show(User $user)
    {
        $roles = Role::pluck('name','id');//all();
        return view('dash.users.show', compact('user','roles'));
    }

    public function errr404()
    {
        return view('errors.404'); 
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

  
   
public function updatePassword(Request $request)
{
    // Validation
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    /** @var User */
    $user = Auth::user();

    // Vérifie que l'ancien mot de passe est correct
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Met à jour le mot de passe
    $user->password = Hash::make($request->password);
    $user->save(); // <== CETTE LIGNE NE DOIT PAS POSER PROBLÈME ICI

    return back()->with('success', 'Mot de passe mis à jour avec succès.');
}


}
