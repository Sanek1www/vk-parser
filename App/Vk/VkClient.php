<?php

namespace App\Vk;

class VkClient 
{
    private const VERSION = '5.131'; 

    public function __construct(
        private string $accessToken,
        private string $baseUrl = 'https://api.vk.com/method/',
    ) {}

    private function prepareUrl(string $vkMethod): string
    {
        return sprintf("%s%s?v=%s", $this->baseUrl, $vkMethod, self::VERSION);
    }

    public function postRequest(array $params, string $vkMethod): array
    {
        $ch = curl_init($this->prepareUrl($vkMethod));
        
        $params['access_token'] = $this->accessToken;
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    
        $response = curl_exec($ch);

        return json_decode($response, true);
    }
}
