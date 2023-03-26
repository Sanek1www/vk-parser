<?php

namespace App\Service;

use App\Repository\UsersRepository;
use App\Vk\VkApi;
use App\Adapters\UserAdapter;

class Service
{
    public function __construct(
        private UsersRepository $usersRepositiry,
        private VkApi $vkApi,
    ) {}

    public function saveUsersFromGroup(string $groupId): void
    {
        $users = [];
        $offset = 0;

        do {
            $users = [];
            $vkUsers = $this->vkApi->getUsersFromGroup($groupId, $offset);
            $offset += count($vkUsers);

            foreach ($vkUsers as $vkUser) {
                $users[] = (new UserAdapter($vkUser))->toUser();
            }
            
            $this->usersRepositiry->insertArray($users);
  
            
        } while (count($users) > 0);

        echo sprintf('Всего участников сохранено: %d', $offset);
        return;
    }
}
