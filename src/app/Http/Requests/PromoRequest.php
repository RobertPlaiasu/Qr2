<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
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
            'price' => ['required','integer','max:20000000','min:1'],
            'picture' => 'sometimes|file|image|mimes:jpeg,jpg,png|max:2048',
            'expire' => 'nullable|date|after:tomorrow',
            'products' => 'required|exists:products,id',
        ];
    }
}
