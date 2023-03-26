<?php 

namespace App\Repository;

use \MongoDB\Collection;

class UsersRepository 
{
    private Collection $collection;

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    public function insertArray(array $users)
    {
        if (empty($users)) {
            return;
        }

        $arrayUsers = [];

        foreach ($users as $user) {
            $arrayUsers[] = $user->toArray();
        }

        $this->collection->insertMany($arrayUsers);

        return;
    }
}
