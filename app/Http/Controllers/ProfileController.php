<?php

namespace App\Http\Controllers;

use App\Models\Outil;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function voirProfil()
    {
        $users = User::all();

        // $user = auth()->user();
            $user = Auth::user();
            
            $mois = Carbon::now()->month;
            $annee = Carbon::now()->year;

            // Tous les outils créés par cet utilisateur
            $outils = Outil::with(['lignesDeVente' => function ($query) use ($mois, $annee) {
                    $query->whereMonth('created_at', $mois)
                        ->whereYear('created_at', $annee);
                }])
                ->where('author_id', $user->id)
                ->get();

            // On collecte toutes les lignes de vente depuis les outils
            $ventesDuMois = $outils->pluck('lignesDeVente')->flatten();

            $totalVentes = $ventesDuMois->count();
            $montantTotal = $ventesDuMois->sum('total');
        
        // test du page error 500 // abort(500);
        return view('dash.users.profile.index', compact('users', 'totalVentes', 'montantTotal', 'ventesDuMois'));
    }

    public function edit()
    {
        return view('dash.users.profile.edit');
    }

    public function update()
    {
        //refuse : auth()->user();
        $user = Auth::user(); // ou User::find($id) si c'est un admin qui édite un autre user
        return view('dash.users.profile.updateProfile', compact('user'));
    }

    public function up(Request $request, UserService $userService)
    {
        $user = Auth::user();
    
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $userService->updateProfile($user, $validated);
    
        return redirect()->route('profile.setting')->with('success', 'Profil mis à jour avec succès.');
    }
    


    public function showCompleteProfileForm()
    {
        return view('dash.users.profile.completeProfile');
    }

    public function handleCompleteProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile-images', 'public');
            $user->image = $path;
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'username' => $request->username,
            'profile_completed' => true,
        ]);

        return Redirect::route('dashboard')->with('success', 'Votre profil a été complété avec succès.');
    }

   
}
