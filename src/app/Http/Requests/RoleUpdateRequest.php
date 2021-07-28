<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
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
            'name' => ['required','max:254','min:3','string',Rule::unique('roles')->ignore($this->role->id)],
            'description' => 'required|max:254|min:4|string',
            'permissions' => 'required|exists:permissions,id',
            'for_admin' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Un nume este necesar pentru rol.',
            'name.max' => 'Numele are mai mult de :max de caractere.',
            'name.min' => 'Numele are mai putin de :min caractere.',
            'name.string' => 'Numele trebuie sa fie de tipul text.',
            'name.unique' => 'Numele rolului trebuie sa fie unic.',

            'description.required' => 'Rolul trebuie să contină o descriere.',
            'description.max' => 'Descrierea are mai mult de :max de caracatere.',
            'description.min' => 'Descrierea are mai putin de :min caracatere.',
            'description.string' => 'Descrierea trebuie sa fie de tipul text.',

            'permissions.required' => 'Este obligatoriu sa alegi o permisiune.',
            'permissions.exists' => 'Permisiunea nu exista in baza de date.',
        ];
    }
}
