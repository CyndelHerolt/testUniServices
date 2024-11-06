<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getUserData(int $userId): array
    {
        $response = $this->client->request('GET', 'http://localhost:8001/api/users/' . $userId);
        return $response->toArray();
    }
}
