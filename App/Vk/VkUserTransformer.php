<?php

namespace App\Vk;

use \App\Vk\Models\User;

class VkUserTransformer 
{
    public static array $fields = [
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'birthDay' => 'bdate',
    ];

    public static function fromArray(array $data): User
    {
        $user = new User();

        foreach (self::$fields as $psrField => $field) {
            $user->{$psrField} = $data[$field] ?? null;
        }

        if (!empty($data['country'])) {
            $user->country = $data['country']['title'];
        }

        if (!empty($data['city'])) {
            $user->city = $data['city']['title'];
        }

        return $user;
    }

    public static function fromList(array $list): array
    {
        $users = [];

        foreach ($list as $data) {
            $users[] = self::fromArray($data);
        }
       
        return $users;
    }
}
