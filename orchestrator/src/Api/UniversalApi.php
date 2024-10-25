<?php

namespace App\Api;

use Symfony\Component\HttpClient\HttpClient;

class UniversalApi
{
    public function request(string $method, string $token, string $endpoint, string $serve, ?array $datas): string
    {
        $client = HttpClient::create();
        $response = $client->request($method, 'http://localhost:'.$serve.'/api/'.$endpoint, [
            'headers' => [
                'Authorization' => $token,
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $datas,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        return $content;
    }
}
