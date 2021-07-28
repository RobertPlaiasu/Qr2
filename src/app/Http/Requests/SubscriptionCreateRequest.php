<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionCreateRequest extends FormRequest
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
            'last_name' => ['required','string','max:60','min:2'],
            'first_name' => ['required','string','max:80','min:2'],
            'plan' => ['required','string'],
            'city' => ['required','string','max:60','min:2'],
            'address' => ['required','string','max:60','min:2'],
            'state' => ['required','string','max:60','min:2'],
            'zip_code' =>  ['required','numeric','min:100000','max:999999'],
        ];
    }
}
