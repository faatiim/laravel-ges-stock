<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Autoriser uniquement les utilisateurs connectés.
     */
    public function authorize(): bool
    {
        return  Auth::check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
       /**
     * Règles de validation.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Le mot de passe actuel est incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    
    /**
     * Messages personnalisés pour les erreurs.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Veuillez entrer votre mot de passe actuel.',
            'password.required' => 'Veuillez entrer un nouveau mot de passe.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ];
    }


}


