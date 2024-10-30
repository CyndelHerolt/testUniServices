<?php

namespace App\Api;

use Symfony\Component\HttpClient\HttpClient;

class UniversalApi
{
    public function request(string $method, string $token, string $endpoint, string $serve, ?array $datas): mixed
    {
        $client = HttpClient::create();
        $response = $client->request($method, 'http://localhost:'.$serve.'/api/'.$endpoint, [
            'headers' => [
                'Content-Type' => 'application/ld+json',
                'Authorization' => $token,
            ],
            'json' => $datas,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();


        return $content;
    }
}
