<?php

namespace App\Adapters;

use \App\Models\User as User;
use \App\Vk\Models\User as VkUser;

class UserAdapter 
{
    
    public function __construct(
        private VkUser $vkUser
    ) {}

    public function toUser(): User
    {
        $user = new User();

        foreach ($user->fields as $field) {
            $user->{$field} = $this->vkUser->{$field} ?? null;
        }

        if ($user->birthDay && count(explode('.', $user->birthDay)) > 2) {
            $user->old = \DateTime::createFromFormat('d.m.Y', $user->birthDay)
            ->diff(new \DateTime('now'))
            ->y;
        }
      
        return $user;
    }
}
