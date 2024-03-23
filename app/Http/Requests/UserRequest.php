<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'nom'=>['required', 'min:2'],
            'prenom'=>['required', 'min:2'],
            'cni'=>['required', 'numeric', 'min:0'],
            'horaires'=>['required', 'numeric', 'min:1'],
            'salaire'=>['required', 'numeric', 'min:1000'],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'telephone'=>['required', 'unique:users,telephone'],
            'email'=>['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
        ];
    }

    /*public function messages():array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le nom est obligatoire',
            'cni.required' => 'Le champ CNI est obligatoire.',
            'cni.numeric' => 'Le champ CNI doit comporter uniquement des chiffres.',
            'cni.min' => 'Désolé, la CNI ne peut pas prendre de nombre négatif.',
            'email.required' => 'L\'email est obligatoire et doit être un mail valide',
            'email.unique' => 'Vous avez déja un compte ! Connectez vous svp !',
            'telephone.unique' => 'Ce numéro de téléphone existe déjà !',
            'role.required' => 'Le role est obligatoire',
            'password.required' => 'Le mot de passe doit être définie et doit avoir au minimum 4 caractères !',
        ];
    }*/
}
