<?php

namespace App\Vk;

use \App\Vk\VkUserTransformer;
use \App\Vk\Exceptions\ApiException;

class VkApi 
{
    private const EXECUTE_METHOD = "execute";

    public function __construct(
        private VkClient $client
    ) {}

    public function getUsersFromGroup(string $groupId, $offset): array
    {
        $code = file_get_contents(__DIR__ . "/VkScript/GetCloubMembersCode.vkscript");
        $code = str_replace('#group_id#', $groupId, $code);
        $code = str_replace('#startOffset#', $offset, $code);

        $params = [
            'code' => $code,
        ];

        $result = $this->client->postRequest($params, self::EXECUTE_METHOD);
        
        if (isset($result['error'])) {
            throw new ApiException(json_encode($result));
        }

        $users = [];

        foreach ($result['response'] as $list) {
            $users = array_merge($users, VkUserTransformer::fromList($list));
        }

        return $users;
    }
}
