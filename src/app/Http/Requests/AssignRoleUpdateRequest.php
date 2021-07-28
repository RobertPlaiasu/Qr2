<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleUpdateRequest extends FormRequest
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
        ];
    }


    public function messages() 
    {
        return [
            'role_id.required' => 'Un rol trebuie ales.',
            'role_id.integer' => 'role_id trebuie sa fie de tip integer.',
            'role_id.exists' => 'Rolul nu exista in baza de date.',
        ];
        
    }
}
