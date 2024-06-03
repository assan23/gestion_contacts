<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $rules = [
            'prenom' => 'required|regex:/^[A-Za-z\s]+$/', // Only letters and spaces, required
            'nom' => 'required|regex:/^[A-Za-z\s]+$/',    // Only letters and spaces, required
            'email' => 'required|email',  // Valid email format, required
            'entreprise' => 'required|regex:/^[A-Za-z0-9\s]+$/', // Only letters, numbers, and spaces, required
            'code_postal' => 'nullable|numeric', // Only numbers, not required
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.alpha' => 'Le prénom doit contenir uniquement des lettres.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.alpha' => 'Le nom doit contenir uniquement des lettres.',
            'email.required' => 'L\'e-mail est obligatoire.',
            'email.email' => 'L\'e-mail doit être un format valide.',
            'entreprise.required' => 'Entreprise est obligatoire.',
            'entreprise.regex' => 'Entreprise doit contenir uniquement des lettres ou des chiffres.',
            'code_postal.numeric' => 'Le nom doit contenir uniquement des chiffres.',
        ];
    }

}
