<?php

namespace App\Rules;

use Laravel\Fortify\Rules\Password;
use Illuminate\Contracts\Validation\Rule;

class PasswordCustomRule extends Password implements Rule
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case $this->requireUppercase
                && ! $this->requireNumeric
                && ! $this->requireSpecialCharacter:
                return __(' :attribute trebuie sa aiba cel putin :length caractere si contine cel putin o litera mare.', [
                    'length' => $this->length,
                ]);

            case $this->requireNumeric
                && ! $this->requireUppercase
                && ! $this->requireSpecialCharacter:
                return __(':attribute trebuie sa aiba cel putin :length caractere si contine cel putin o cifra.', [
                    'length' => $this->length,
                ]);

            case $this->requireSpecialCharacter
                && ! $this->requireUppercase
                && ! $this->requireNumeric:
                return __(':attribute trebuie sa aiba cel putin :length caractere si sa contina cel putin un caracter special.', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireNumeric
                && ! $this->requireSpecialCharacter:
                return __(':attribute trebuie sa aiba cel putin :length caractere si sa contina o litera mare si o cifra', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireSpecialCharacter
                && ! $this->requireNumeric:
                return __(':attribute trebuie sa aiba cel putin :length caractere si sa contina o litera mare si un caracter special.', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireNumeric
                && $this->requireSpecialCharacter:
                return __(':attribute trebuie sa aiba cel putin :length caractere si sa contina o litera mare, o cifra si un caracter special.', [
                    'length' => $this->length,
                ]);

            default:
                return __(':attribute trebuie sa aiba cel putin :length caractere.', [
                    'length' => $this->length,
                ]);
        }
    }
}
