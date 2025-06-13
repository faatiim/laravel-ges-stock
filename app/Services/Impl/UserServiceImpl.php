<?php

namespace App\Services\Impl;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\TemporaryPasswordMail;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class UserServiceImpl implements UserService
{
    public function createWithEmailRoleOnly(array $data): User
    {
        $tempPassword = Str::random(10);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($tempPassword),
            'is_active' => true,
            'force_password_reset' => true,
            'user_ref' => 'USR-' . strtoupper(Str::random(6)),
        ]);

        $role = Role::where('name', $data['role'])->firstOrFail();
        $user->assignRole($role);

        // Mail::to($user->email)->send(new TemporaryPasswordMail($user, $tempPassword));     
        // ⚠️ Envoi de mail sécurisé avec gestion d'erreur
        try {
            Mail::to($user->email)->send(new TemporaryPasswordMail($user, $tempPassword));
        } catch (\Exception $e) {
            // La transaction va rollback automatiquement
            throw new \Exception("Erreur lors de l'envoi de l'e-mail : " . $e->getMessage());
        }

        return $user;
    }

    public function login(array $credentials, bool $remember = false): ?User
    {
        if (!Auth::attempt($credentials, $remember)) {
            return null;
        }

        $user = Auth::user();

        if ($user->first_login_at === null) {
            $user->first_login_at = now();
        }
           // cette erreur revient souvent: Undefined method 'save'.intelephense(P1013)
        // l'IDE (Intelephense dans VSCode) ne reconnaît pas correctement le type de $user, ce qui l’empêche de savoir que save() est bien disponible sur cet objet.
        // La solution propre est de lui préciser le type de $user pour qu’Intelephense sache qu’il s’agit bien d’un objet App\Models\User.
        // ce corrige en faisant: 
            /** @var User $user */

        $user->last_login_at = now();
        $user->save();

        return $user;
    }

    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function forceResetPassword(User $user, string $newPassword): void
    {
        $user->password = Hash::make($newPassword);
        $user->force_password_reset = false;
        $user->save();
    }



    public function sendResetLink(array $data): string
    {
        return Password::broker()->sendResetLink(['email' => $data['email']]);
    }

    public function resetPassword(array $data): string
    {
        return Password::broker()->reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );
    }
    


    // public function resetPassword(User $user, string $newPassword): void
    // {
    //     $user->password = Hash::make($newPassword);
    //     $user->save();
    // }

    public function needsProfileCompletion(User $user): bool
    {
        return !$user->profile_completed;
    }

    /**
     * Compléter le profil d'un utilisateur avec gestion d'image
     */
    public function completeProfile(User $user, array $data): User
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imagePath = $data['image']->store('users/images', 'public');
            $user->image = $imagePath;
        }

        $user->fill([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'profile_completed' => true,
        ]);

        $user->save();

        return $user;
    }


public function updateProfile(User $user, array $data): User
{
    // Mise à jour des champs texte
    $user->fill([
        'first_name' => $data['first_name'] ?? $user->first_name,
        'last_name' => $data['last_name'] ?? $user->last_name,
        'username' => $data['username'] ?? $user->username,
        'email' => $data['email'] ?? $user->email,
        'phone' => $data['phone'] ?? $user->phone,
        'address' => $data['address'] ?? $user->address,
    ]);

    // Gestion du mot de passe si fourni
    if (!empty($data['password'])) {
        $user->password = Hash::make($data['password']);
    }

    // Gestion de l'image
    if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
        // Supprimer l’ancienne image si elle existe
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // Stocker la nouvelle image dans 'profile-images/'
        $imagePath = $data['image']->store('profile-images', 'public');
        $user->image = $imagePath;
    }

    $user->save();

    return $user;
}

}
