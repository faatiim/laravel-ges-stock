<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'description' => 'nullable|string',
            'isActive' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.unique' => 'Ce nom de catégorie existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'isActive.required' => 'Le statut de la catégorie est obligatoire.',
            'isActive.boolean' => 'Le statut doit être actif ou désactivé.',
        ];
    }
}
