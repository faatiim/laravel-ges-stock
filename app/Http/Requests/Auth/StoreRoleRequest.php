<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|unique:roles,name',
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
