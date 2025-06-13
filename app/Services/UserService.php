<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

interface UserService
{
    public function createWithEmailRoleOnly(array $data): User;

    public function login(array $credentials, bool $remember = false): ?User;

    public function logout(): void;

    public function forceResetPassword(User $user, string $newPassword): void;

    public function sendResetLink(array $data): string;

    // public function resetPassword(User $user, string $newPassword): void;
    public function resetPassword(array $data): string;

    // public function forgotPassword(User $user, string $newPassword): void;

    public function needsProfileCompletion(User $user): bool;

    public function updateProfile(User $user, array $data): User;
}