<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|max:254|min:2',
            'price' => ['required','max:10','regex:/^\d+(\.\d{1,2})?$/', Rule::notIn([0,'0'])],
            'picture' => 'sometimes|file|image|mimes:jpeg,jpg,png|max:2048',
            'weight' => 'required|integer|max:100000|min:1',
            'ingredients' => 'sometimes|max:254',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Campul nume trebuie completat.',
            'name.max' => 'Numarul maxim de caractere permis pentru nume este :max.',
            'name.min' => 'Numarul minim de caractere permis pentru nume este :min.',
            'name.string' => 'Numele trebuie sa fie de tipul text.',

            'price.required' => 'Pretul trebuie completat',
            'price.regex' => 'Pretul trebuie sa aiba maxim 2 zecimale si sa fie mai mare decat 0.',
            'price.max' => 'Pretul trebuie sa aiba maxim :max cifre.',
            'price.not_in' => 'Pretul trebuie sa fie diferit de 0.',

            'picture.file' => 'Poza trebuie sa fie un fisier.',
            'picture.image' => 'Poza trebuie sa fie o imagine.',
            'picture.mimes:jpeg,jpg,png' => 'Poza trebuie sa aiba urmatoarele extensii:jpeg,png si jpg.',
            'picture.max' => 'Poza poate avea maxim 2MB.',

            'weight.required' => 'Este obligatoriu sa pui gramajul produsului.',
            'weight.integer' => 'Gramajul trebuie sa fie un numar natural.',
            'weight.max' => 'Gramajul trebuie sa fie mai mic decat :max g.',
            'weight.min' => 'Gramajul trebuie sa fie mai mare sau egal cu :min g.',

            'ingredients.max' => 'Numarul maxim de caractere pentru ingrediente este :max',
            'ingredients.string' => 'Ingrediente trebuie sa fie de tipul text.',
        ];
    }
}
