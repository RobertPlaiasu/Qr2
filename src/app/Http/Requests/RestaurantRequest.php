<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:60|string|min:3',
            'description' => 'sometimes|max:65535',
            'location' => 'required|max:255|min:5|string',
            'picture' => 'sometimes|file|image|mimes:jpeg,jpg,png|max:2048',
            'city_id' => 'required|integer|exists:cities,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Un nume este necesar pentru restaurant.',
            'name.max' => 'Numele are mai mult de :max caractere.',
            'name.min' => 'Numele are mai putin de :min caractere.',
            'name.string' => 'Numele trebuie sa fie text.',

            'description.string' => 'Descrierea este de tipul text',
            'description.max' => 'Descrierea are mai mult de :max de caracatere.',

            'location.required' => 'Restaurantul trebuie sa aiba o adresa.',
            'location.max' => 'Adresa are mai mult de :max caractere',
            'location.min' => 'Adresa are mai putin de :min caractere.',

            'city_id.required' => 'Trebuie atribuit un oraș restaurantului.',
            'city_id.integer' => 'Campul city_id trebuie sa fie un numar intreg.',
            'city_id.exists' => 'Orasul nu exista in baza de date.',
            
            'picture.file' => 'Poza trebuie sa fie un fisier.',
            'picture.image' => 'Poza trebuie sa fie o imagine.',
            'picture.mimes:jpeg,jpg,png' => 'Poza trebuie sa aiba urmatoarele extensii:jpeg,png si jpg.',
            'picture.max' => 'Poza poate avea maxim 2MB.',
        ];
    }
}
