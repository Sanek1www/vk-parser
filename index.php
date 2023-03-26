<?php

require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';

if (count($argv) < 2) {
    echo 'Используйте php index.php <group_id>';
    die;
}

$groupId = $argv[1];

$mongoDBClient = new MongoDB\Client($config['mongoDBUrl']);
$mongoDBCollection = $mongoDBClient->{$config['database']}->{$config['collection']};

$mongoDBRepository = new App\Repository\UsersRepository($mongoDBCollection);

$vkClient = new App\Vk\VkClient($config['access_token']);
$vkApi = new App\Vk\VkApi($vkClient);

$service = new App\Service\Service($mongoDBRepository, $vkApi);

$service->saveUsersFromGroup($groupId);
