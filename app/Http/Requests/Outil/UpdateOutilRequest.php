<?php

namespace App\Http\Requests\Outil;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutilRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:outils,title',
            'etat' => 'nullable|string|max:255',
            'reference' => 'unique, required',
            'description' => 'nullable|string',
            'isActive' => 'nullable|boolean',
            'isSharable' => 'nullable|boolean',
            'prix_unitaire' => 'required|numeric|min:0',
            'prix_achat' => 'required|numeric|min:0',
            'prix_gros' => 'required|numeric|min:0',
            'stock_initial' => 'required|numeric|min:0',
            'stock_actuel' => 'numeric|min:0',
            'seuil_alerte' => 'nullable|numeric|min:0',
            'unite' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            // 'author_id' => 'required|exists:users,id', // ← AJOUT ICI
            'author_id' => 'sometimes|nullable|exists:users,id',

        ];
    }
}
