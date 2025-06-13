<?php

namespace App\Http\Requests\Auth;
use Illuminate\Support\Facades\Auth;


use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
            /** @var User|null $user */
            $user = Auth::user();
            return $user && $user->hasRole('admin');


        // return auth()->check() && auth()->user()->hasRole('admin');
        // return Auth::check() && Auth::user()->hasRole('admin');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
        ];
    }
}
