<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'required|string|max:254|min:3|unique:permissions,name',
            'description' => 'required|string|max:254|min:5',
        ];
    }


    public function messages() 
    {
        return [
            'name.required' => 'Campul nume trebuie completat.',
            'name.max' => 'Numarul maxim de caractere permis pentru nume este :max.',
            'name.min' => 'Numarul minim de caractere permis pentru nume este :min.',
            'name.string' => 'Numele trebuie sa fie de tipul text.',
            'name.unique' => 'Numele trebuie sa fie unic in permisiuni.',

            'description.required' => 'Descrierea este obligatorie.',
            'description.string' => 'Descrierea trebuie sa fie de tipul text.',
            'description.max' => 'Numarul maxim de caractere permis pentru descriere este :max.',
            'description.min' => 'Numarul minim de caractere permis pentru descriere este :min.',
        ];
    }
}
