<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleCreateRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'role_id' => 'required|integer|exists:roles,id',
            'restaurant_id' => 'sometimes|integer|exists:restaurants,id',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Un utilizator trebuie ales.',
            'user_id.integer' => 'user_id trebuie sa fie de tip numar.',
            'user_id.exists' => 'Utilizatorul trebuie sa existe in baza de date.',

            'role_id.required' => 'Un rol trebuie ales.',
            'role_id.integer' => 'role_id trebuie sa fie de tip integer.',
            'role_id.exists' => 'Rolul nu exista in baza de date.',

            'restaurant_id.required' => 'Un restaurant trebuie ales.',
            'restaurant_id.integer' => 'restaurant_id trebuie sa fie de tip numar.',
            'restaurant_id.exists' => 'Restaurantul nu exista in baza de date.',
        ];
    }
}
