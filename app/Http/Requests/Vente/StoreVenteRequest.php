<?php

namespace App\Http\Requests\Vente;

use Illuminate\Foundation\Http\FormRequest;

class StoreVenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // A affiner selon les rôles
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'moyen_paiement' => 'required|string|max:50',
            'date_paiement'  => 'nullable|date',

            'lignes' => 'required|array|min:1',
            'lignes.*.outil_id' => 'required|exists:outils,id',
            'lignes.*.quantite' => 'required|numeric|min:0.5',
            'lignes.*.mode_vente' => 'required|in:physique,logique',
        ];
    }

    public function messages(): array
    {
        return [
            'lignes.required' => 'Vous devez ajouter au moins un outil à la vente.',
            'lignes.*.outil_id.required' => 'L\'ID de l\'outil est obligatoire.',
            'lignes.*.quantite.required' => 'La quantité est obligatoire pour chaque outil.',
        ];
    }
}
