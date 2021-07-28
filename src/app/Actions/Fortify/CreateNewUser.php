<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ],[
            'name.required' => 'Campul Nume trebuie completat.',
            'name.string' => 'Campul Nume trebuie sa fie un text.',
            'name.max' => 'Campul Nume trebuie sa aiba maxim :max de caractere.',

            'email.required' => 'Campul Email trebuie completat.',
            'email.string' => 'Campul Email trebuie sa fie un text.',
            'email.email' => 'Campul Email trebuie sa fie o adresa de email valid.',
            'email.max' => 'Campul Email trebuie sa aiba maxim :max caractere.',
            'email.unique' => 'Exista deja adresa de email in baza noastra de date.',

            'password.required' => 'Campul :attribute este obligatoriu.',
            'password.string' => 'Campul :attribute trebuie sa fie text.',
            'password.confirmed' => 'Campul parola trebuie sa fie la fel cu confirma parola.',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
