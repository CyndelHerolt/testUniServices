<?php

namespace App\Api\ScolariteApi;

use Symfony\Component\HttpClient\HttpClient;

class NoteApi
{
    public function create(array $datas): string
    {
        // envoyer $datas en POST à l'API à http://localhost:8002/api/evaluations
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8002/api/evaluations', [
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
