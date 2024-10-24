<?php

namespace App\Api\UserApi;

use Symfony\Component\HttpClient\HttpClient;

class LoginApi
{
    public function login(array $datas): string
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8001/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $datas,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        return $content;
    }
}
