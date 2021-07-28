<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|string|max:255|email',
        ];
    }

    public function messages() 
    {
        return [
            'role_id.required' => 'Un rol trebuie ales.',
            'role_id.integer' => 'role_id trebuie sa fie de tip integer.',
            'role_id.exists' => 'Rolul nu exista in baza de date.',

            'email.required' => 'Completeaza campul email.',
            'email.string' => 'email trebuie sa fie de tipul text.',
            'email.max' => 'Email-ul trebuie aiba maxim :max de caractere.',
            'email.email' => 'Email-ul nu este valid.',
        ];
    }
}
