<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name,' . $this->route('role')->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom du rôle est requis.',
            'name.unique' => 'Ce nom de rôle existe déjà.',
            'permissions.required' => "Veuillez l'assigner au moins une permission.",
            'permissions.min' => 'Un rôle doit avoir au moins une permission.',
        ];
    }
}
