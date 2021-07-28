<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
           'name' => 'required|string|max:50',
           'county_id' => 'required|integer|exists:counties,id',
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => 'Numele trebuie completat.',
            'name.string' => 'Numele trebuie sa fie de tipul text.',
            'name.max' => 'Numarul maxim de caractere permis este :max.',

            'county_id.required' => 'Alege un judet.',
            'county_id.integer' => 'county_id trebuie sa fie un numar.',
            'county_id.exists' => 'Judetul nu exista in baza de date.',
        ];
    }
}
