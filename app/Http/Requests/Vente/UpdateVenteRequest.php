<?php

namespace App\Http\Requests\Vente;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'lignes.*.quantite' => 'required|integer|min:1',
        ];
    }
}
