<?php

namespace App\Api\ScolariteApi;

use Symfony\Component\HttpClient\HttpClient;

class EdtApi
{
    public function getEdtWeek(array $datas): string
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8002/edt/get/week', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $datas,
        ]);

        return $response->getContent();
    }
}
