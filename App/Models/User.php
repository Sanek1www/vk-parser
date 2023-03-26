<?php

namespace App\Models;

class User 
{
    public array $fields = [
        'firstName',
        'lastName',
        'birthDay',
        'city',
        'country',
        'old',
    ];

    public function toArray(): array
    {
        $result = [];

        foreach ($this->fields as $field) {
            if ($this->{$field}) {
                $result[$field] = $this->{$field};
            }
        }

        return $result;
    }
}
