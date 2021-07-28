<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ],[
            'current_password.required' => 'Parola actuala nu este completata.',
            'current_password.string' => 'Parola actuala trebuie sa fie de tipul text.',

            'password.required' => 'Campul :attribute este obligatoriu.',
            'password.string' => 'Campul :attribute trebuie sa fie text.',
            'password.confirmed' => 'Campul parola trebuie sa fie la fel cu confirma parola.',
        ])->after(function ($validator) use ($user, $input) {
            if (! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('Parola nu este cea corecta!'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
