<?php

namespace App\Api;

use Symfony\Component\HttpClient\HttpClient;

class UniversalApi
{
    public function request(string $method, string $token, string $endpoint, string $serve): string
    {
        $client = HttpClient::create();
        $response = $client->request($method, 'http://localhost:'.$serve.'/api/'.$endpoint, [
            'headers' => [
                'Authorization' => $token,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        return $content;
    }
}
