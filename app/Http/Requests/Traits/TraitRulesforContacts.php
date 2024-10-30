<?php

namespace App\Http\Requests\Traits;

trait TraitRulesforContacts
{
    public function rules(): array
    {
        return [
            'full_name' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|regex:/^(\+?\d{1,3}?)?[- .]?\(?\d{1,4}?\)?[- .]?\d{1,4}[- .]?\d{1,9}$/',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'photo_path' => 'nullable|string|max:255',
        ];
    }
}
