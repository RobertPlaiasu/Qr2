<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute trebuie acceptat(a).',
    'active_url' => ':attribute nu este un URL valid.',
    'after' => ':attribute trebuie sa fie mai mare decat data de :date.',
    'after_or_equal' => ':attribute trebuie sa fie mai mare sau egal decat data de :date.',
    'alpha' => ':attribute trebuie sa contina doar litere.',
    'alpha_dash' => ':attribute trebuie sa contina doar litere, numere, dashes si underscore.',
    'alpha_num' => ':attribute trebuie sa contina doar litere si numere.',
    'array' => ':attribute trebuie sa fie un array.',
    'before' => ':attribute trebuie sa fie inainte de :date.',
    'before_or_equal' => ':attribute trebuie sa fie inainte sau egal cu :date.',
    'between' => [
        'numeric' => ':attribute trebuie sa fie intre :min si :max.',
        'file' => ':attribute trebuie sa fie intre :min si :max killobytes.',
        'string' => ':attribute trebuie sa fie intre :min si :max caractere.',
        'array' => ':attribute trebuie sa aiba intre :min si :max elemente.',
    ],
    'boolean' => 'Campul :attribute trebuie sa fie adevarat sau fals.',
    'confirmed' => ':attribute trebuie confirmat(a).',
    'date' => ':attribute nu este o data valida.',
    'date_equals' => ':attribute trebuie sa fie egal cu data :date.',
    'date_format' => ':attribute trebuie sa fie de formatul :format.',
    'different' => ':attribute si :other trebuie sa fie diferite.',
    'digits' => ':attribute trebuie sa aiba :digits cifre.',
    'digits_between' => ':attribute trebuie sa fie intre :min si :max cifre.',
    'dimensions' => ':attribute are o dimensiune a imaginii invalida.',
    'distinct' => ':attribute are un camp duplicat.',
    'email' => ':attribute trebuie sa fie o adresa de email valida.',
    'ends_with' => ':attribute trebuie sa se incheie cu urmatoarele: :values.',
    'exists' => 'Campul :attribute este invalid.',
    'file' => ':attribute trebuie sa fie un fisier.',
    'filled' => ':attribute campul trebuie sa aiba o valoare.',
    'gt' => [
        'numeric' => ':attribute trebuie sa fie mai mare decat :value.',
        'file' => ':attribute trebuie sa fie decat :value kilobytes.',
        'string' => ':attribute trebuie sa fie mare decat :value caractere.',
        'array' => ':attribute trebuie sa aiba mai mult de :value elemente.',
    ],
    'gte' => [
        'numeric' => ':attribute trebuie sa fie mai mare sau egal cu :value.',
        'file' => ':attribute trebuie sa fie mare sau egal cu :value kilobytes.',
        'string' => ':attribute trebuie sa fie mai mare sau egal cu :value caractere.',
        'array' => ':attribute trebuie sa aiba :value elemente sau mai multe.',
    ],
    'image' => ':attribute trebuie sa fie o imagine.',
    'in' => ':attribute selectat este invalid.',
    'in_array' => ':attribute nu exista in :other.',
    'integer' => ':attribute trebuie sa fie un numar intreg.',
    'ip' => ':attribute trebuiesa fie o adresa IP valida.',
    'ipv4' => ':attribute trebuie sa fie o adresa IPv4 valida.',
    'ipv6' => ':attribute trebuie sa fie o adresa IPv6 valida.',
    'json' => ':attribute nu este un JSON valid.',
    'lt' => [
        'numeric' => ':attribute trebuie sa fie mai mic decat :value.',
        'file' => ':attribute trebuie sa fie mai mic decat :value kilobytes.',
        'string' => ':attribute trebuiesa fie mai mic decat :value caractere.',
        'array' => ':attribute trebuie sa aiba mai putin de :value elemente.',
    ],
    'lte' => [
        'numeric' => ':attribute trebuiesa fie mai mic sau egal cu :value.',
        'file' => ':attribute trebuie sa fie mai mic sau egal cu :value kilobytes.',
        'string' => ':attribute trebuiesa fie mai mic sau egal cu :value caractere.',
        'array' => ':attribute trebuie sa mai putin sau egal cu :value elemente.',
    ],
    'max' => [
        'numeric' => ':attribute nu trebuie sa fie mai mare decat :max.',
        'file' => ':attribute nu trebuie sa fie mai mare decat :max de kilobytes.',
        'string' => ':attribute nu trebuie sa fie mai mare decat :max de caractere.',
        'array' => ':attribute nu trebuie sa aiba mai mult decat :max elemente.',
    ],
    'mimes' => ':attribute trebuie sa fie o fila de tipul: :values.',
    'mimetypes' => ':attribute trebuie sa fie o fila de tipul: :values.',
    'min' => [
        'numeric' => ':attribute trebuie sa fie cel putin :min.',
        'file' => ':attribute trebuie sa fie cel putin :min de kilobytes.',
        'string' => ':attribute trebuie sa fie cel putin :min de caractere.',
        'array' => ':attribute trebuie sa aiba cel putin :min elemete.',
    ],
    'not_in' => ':attribute este invalid.',
    'not_regex' => ':attribute formatul este invalid.',
    'numeric' => ':attribute trebuie sa fie un numar.',
    'password' => 'Parola este incorecta',
    'present' => ':attribute trebuie sa fie prezent.',
    'regex' => ':attribute formatul este invalid.',
    'required' => 'Campul este obligatoriu',
    'required_if' => 'Campul este obligatoriu daca :other este :value.',
    'required_unless' => 'Campul este obligatoriu doar daca :other este in :values.',
    'required_with' => ' Campul este obligatoriu daca :values este prezent.',
    'required_with_all' => 'Campul este obligatoriu daca :values este prezent.',
    'required_without' => 'Campul este obligatoriu atunci cand :values nu este prezent.',
    'required_without_all' => 'Campul este obligatoriu atunci cand niciunu din campurile :values nu sunt prezente.',
    'same' => ':attribute si :other trebuie sa fie la fel.',
    'size' => [
        'numeric' => ':attribute trebuie sa fie :size.',
        'file' => ':attribute trebuie sa fie de :size kilobytes .',
        'string' => ':attribute trebuie sa fie de :size caractere.',
        'array' => ':attribute trebuie sa contina :size de elemente.',
    ],
    'starts_with' => ':attribute trebuie sa inceapa cu una din urmatoarele valori: :values.',
    'string' => ':attribute trebuie sa fie un text.',
    'timezone' => ':attribute trebuie sa fie o zona valida.',
    'unique' => ':attribute exista deja.',
    'uploaded' => ':attribute nu a reusit sa se incarce.',
    'url' => ':attribute este un url invalid.',
    'uuid' => ':attribute trebuie sa fie un UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'Email-ul',
        'password' => 'Parola'

    ],

];
