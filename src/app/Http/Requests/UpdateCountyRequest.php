<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountyRequest extends FormRequest
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
            'name' => ['required','string','max:35',Rule::unique('counties')->ignore($this->id)],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Un nume este necesar pentru judet.',
            'name.max' => 'Numele are mai mult de :max de caractere.',
            'name.string' => 'Numele trebuie sa fie de tipul text.',
            'name.unique' => 'Numele judetului trebuie sa fie unic.',
        ];
    }
}
