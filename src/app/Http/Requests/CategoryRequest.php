<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|max:254|min:2|string',
        ];
    }

    public function messages()  
    {
        return [
            'name.required' => 'Campul nume trebuie completat.',
            'name.max' => 'Numarul maxim de caractere permis este :max.',
            'name.min' => 'Numarul minim de caractere permis este :min.',
            'name.string' => 'Numele trebuie sa fie de tipul string.',
        ];
    }
}
