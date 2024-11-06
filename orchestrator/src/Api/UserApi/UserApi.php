<?php

namespace App\Api\UserApi;

use Symfony\Component\HttpClient\HttpClient;

class UserApi
{
    public function getUserData(int $userId): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/api/users/' . $userId);
        return $response->toArray();
    }

    public function register(array $datas): string
    {
        // envoyer $datas en POST à l'API à http://localhost:8001/api/users
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8001/api/users', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $datas,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        return $content;
    }
}
